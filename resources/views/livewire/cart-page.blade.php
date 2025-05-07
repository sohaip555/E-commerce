<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                        <tr>
                            <th class="text-left font-semibold">Product</th>
                            <th class="text-left font-semibold">Price</th>
                            <th class="text-left font-semibold">Quantity</th>
                            <th class="text-left font-semibold">Total</th>
                            <th class="text-left font-semibold">Remove</th>
                        </tr>
                        </thead>
                        @foreach($cart_items as $index => $item)
                            <tbody wire:key="{{$item['product_id']}}">
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <img class="h-16 w-16 mr-4" src="{{$item['image']}}" alt="Product image">
                                        <span class="font-semibold">{{$item['name']}}</span>
                                    </div>
                                </td>
                                <td class="py-4">{{ \Illuminate\Support\Number::currency($item['unit_amount'])}}</td>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <button wire:click="decrease({{$item['product_id']}})" class="border rounded-md py-2 px-4 mr-2
                                        hover:bg-red-500 hover:text-white hover:border-red-700">-</button>
                                        <span class="text-center w-8">{{$item['quantity']}}</span>
                                        <button wire:click="increase({{$item['product_id']}})" class="border rounded-md py-2 px-4 ml-2
                                        hover:bg-red-500 hover:text-white hover:border-red-700">+</button>
                                    </div>
                                </td>
                                <td class="py-4">{{ \Illuminate\Support\Number::currency($item['total_amount'])}}</td>
                                <td><button  wire:click.prevent="removeItem({{$item['product_id']}})"  class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">Remove</button></td>
                            </tr>
                            <!-- More product rows -->
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>{{\Illuminate\Support\Number::currency($grand_amount)}}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>$$0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold">{{\Illuminate\Support\Number::currency($grand_amount)}}</span>
                    </div>
                    <button wire:click="checkout()" type="button" class="bg-blue-500 text-white py-2 px-4 hover:bg-blue-700 rounded-lg mt-4 w-full">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
