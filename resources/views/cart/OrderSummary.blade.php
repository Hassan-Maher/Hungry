<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Summary
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white shadow-md rounded-xl p-6">

        {{-- ملخص الأوردر --}}
        <h3 class="text-2xl font-semibold mb-4">Order Summary</h3>

        <div class="mb-4">
            <p class="flex justify-between">
                <span>Cart Price:</span>
                <span class="font-semibold">{{ $order_summary['order_price'] }} EGP</span>
            </p>

            <p class="flex justify-between">
                <span>Taxes:</span>
                <span class="font-semibold">{{ $order_summary['additional_cost']->taxes }} EGP</span>
            </p>

            <p class="flex justify-between">
                <span>Delivery Fees:</span>
                <span class="font-semibold">{{ $order_summary['additional_cost']->delivery_fees }} EGP</span>
            </p>

            <hr class="my-2">

            <p class="flex justify-between text-lg font-bold text-green-700">
                <span>Total:</span>
                <span>{{ $order_summary['total'] }} EGP</span>
            </p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            {{-- رقم الهاتف --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Phone Number *</label>
                <input type="text" name="phone"
                       class="w-full p-2 border rounded-lg"
                       placeholder="Enter phone number"
                       required>
            </div>

            {{-- العنوان --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Address (Optional) </label>
                <input type="text" name="address"
                       class="w-full p-2 border rounded-lg"
                       placeholder="If Not Whriten We Take Account Address">
            </div>

            {{-- طرق الدفع (بطاقات احترافية) --}}
            <h3 class="text-xl font-semibold mb-3">Select Payment Method</h3>

            <div class="grid grid-cols-1 gap-4">
                @foreach($payment_methods as $method)
                    <label class="block cursor-pointer">
                        <input type="radio" name="payment_method"
                               value="{{ $method->id }}"
                               class="hidden peer"
                               @checked($prefered_method == $method->id)>

                        <div class="p-4 border rounded-xl shadow-sm peer-checked:border-green-600 peer-checked:bg-green-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-lg">{{ $method->name }}</p>
                                    <p class="text-sm text-gray-500">Click to select this method</p>
                                </div>

                                <div class="w-6 h-6 rounded-full border border-gray-400 peer-checked:bg-green-600 peer-checked:border-green-600"></div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- اختيار وسيلة الدفع كمفضلة --}}
            <div class="mt-4 flex items-center gap-2">
                <input type="checkbox" name="set_as_prefer" value="1"
                       class="w-5 h-5"
                       @checked($prefered_method)>
                <label class="font-semibold">Set as preferred payment method</label>
            </div>

            {{-- زر تأكيد الدفع --}}
            <button type="submit"
                    class="w-full mt-6 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 text-lg">
                Confirm Payment
            </button>
        </form>

        {{-- زر العودة --}}
        <div class="mt-4 text-center">
            <a href="{{ route('cart.index') }}"
               class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">
                Back to Cart
            </a>
        </div>

    </div>

</x-app-layout>
