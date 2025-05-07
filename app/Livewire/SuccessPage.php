<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Stripe;

class SuccessPage extends Component
{

    #[Url()]
    public $session_id;

    public function render()
    {
        $order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();
//        dd($order->address->first_name);
        if ($this->session_id){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($this->session_id);

            if ($session->payment_status == 'paid') {
                $order->payment_status = 'paid';
                $order->save();
            }
            elseif ($session->payment_status !== 'paid') {
                $order->payment_status = 'failed';
                $order->save();
                return redirect()->route('cancel');
            }
//            dd($session);
        }
        return view('livewire.success-page', [
            'order' => $order,
        ]);
    }
}
