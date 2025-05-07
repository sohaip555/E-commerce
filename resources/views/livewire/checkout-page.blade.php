<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>

    <form wire:submit.prevent="placeOrder">
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Shipping Address
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    First Name
                                </label>
                                <input wire:model.lazy="first_name" id="first_name" type="text"
                                       class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('first_name') ? 'border-red-500' : 'border-gray-300' }}">
                                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Last Name
                                </label>
                                <input wire:model.lazy="last_name" id="last_name" type="text"
                                       class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('last_name') ? 'border-red-500' : 'border-gray-300' }}">
                                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                Phone
                            </label>
                            <input wire:model.lazy="phone" id="phone" type="text"
                                   class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }}">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="address">
                                Address
                            </label>
                            <input wire:model.lazy="address" id="address" type="text"
                                   class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }}">
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                City
                            </label>
                            <input wire:model.lazy="city" id="city" type="text"
                                   class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('city') ? 'border-red-500' : 'border-gray-300' }}">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                    State
                                </label>
                                <input wire:model.lazy="state" id="state" type="text"
                                       class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('state') ? 'border-red-500' : 'border-gray-300' }}">
                                @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    ZIP Code
                                </label>
                                <input wire:model.lazy="zip" id="zip" type="text"
                                       class="w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white border {{ $errors->has('zip') ? 'border-red-500' : 'border-gray-300' }}">
                                @error('zip') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-lg font-semibold mb-4">
                        Select Payment Method
                    </div>

                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:model="payment_method" class="hidden peer" id="payment_cash" name="payment" type="radio" value="cod">
                            <label for="payment_cash" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Cash on Delivery</div>
                                </div>
                            </label>
                        </li>

                        <li>
                            <input wire:model="payment_method" class="hidden peer" id="payment_stripe" name="payment" type="radio" value="stripe">
                            <label for="payment_stripe" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Stripe</div>
                                </div>
                            </label>
                        </li>
                    </ul>

                    @error('payment_method')
                    <span class="text-red-500 text-sm block mt-2">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
                    </div>

                    <div class="flex justify-between mb-2 font-bold">
                        <span>Subtotal</span>
                        <span>{{ \Illuminate\Support\Number::currency($grand_amount) }}</span>
                    </div>

                    <div class="flex justify-between mb-2 font-bold">
                        <span>Taxes</span>
                        <span>0.00</span>
                    </div>

                    <div class="flex justify-between mb-2 font-bold">
                        <span>Shipping Cost</span>
                        <span>0.00</span>
                    </div>

                    <hr class="bg-slate-400 my-4 h-1 rounded">

                    <div class="flex justify-between mb-2 font-bold">
                        <span>Grand Total</span>
                        <span>{{ \Illuminate\Support\Number::currency($grand_amount) }}</span>
                    </div>
                </div>

                <button wire:click="placeOrder" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    <span wire:loading.remove>Place Order</span>
                    <span wire:loading>Processing..</span>
                </button>

                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>

                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach($cart_items as $index => $item)
                            <li class="py-3 sm:py-4" wire:key="{{ $item['product_id'] }}">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full" src="https://iplanet.one/cdn/shop/files/iPhone_15_Pro_Max_Blue_Titanium_PDP_Image_Position-1__en-IN_1445x.jpg?v=1695435917">
                                    </div>

                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            Quantity: {{ $item['quantity'] }}
                                        </p>
                                    </div>

                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ \Illuminate\Support\Number::currency($item['total_amount']) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </form>
</div>
