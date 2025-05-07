<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutPage extends Component
{

    public  $cart_items;
    public $grand_amount;

    public $first_name;
    public $last_name;

    public $phone;

    public $address;
    public $city;

    public $state;
    public $zip;

    // Payment method
    public $payment_method;

    // Validation rules
    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip' => 'required|string|max:20',
        'payment_method' => 'required',
    ];

    public function placeOrder()
    {

//        dd($cart_items);
//        dd($this->payment_method);
        $this->validate();

        $cart_items = CartManagement::getCartItemsFromCookie();


        foreach ($cart_items as $item) {

            $line_items[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'unit_amount' => $item['unit_amount'] * 100, // يجب أن يكون بالسنت
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }



        $order = new Order();
        $order->user_id = auth()->id();
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order-> currency = 'USD';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = '';


        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip;

        $redirect_url = '';

        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            $redirect_url = $sessionCheckout->url;
        } else {
            $redirect_url = route('success');
        }


        $order->save();
        $address->order_id = $order->id;
        $address->save();

        foreach ($cart_items as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_amount' => $item['unit_amount'],
                'total_amount' => $item['quantity'] * $item['unit_amount'],
            ]);
        }

        CartManagement::clearCartItems();

         Mail::to(auth()->user())->send(new OrderPlaced($order));
        return redirect($redirect_url);
    }

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_amount = CartManagement::calculateGrandTotal($this->cart_items);

//        dd($this->cart_items);
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
