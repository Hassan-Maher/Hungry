<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Options to {{ $item->product->name }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6">

        {{-- اسم المنتج وصورته --}}
        <div class="bg-white shadow-md rounded-xl p-6 mb-6 flex items-center gap-6">
            <img src="{{ asset('storage/' . $item->product->img) }}" 
                class="w-32 h-32 object-cover rounded-lg shadow">
            <div>
                <h3 class="text-2xl font-semibold">{{ $item->product->name }}</h3>
                <p class="text-gray-600 mt-1">Add options for this product</p>
            </div>
        </div>

        {{-- Form لإضافة الخيارات --}}
        <form action="{{ route('cart_option.store', $item->id) }}" method="POST">
            @csrf

            {{-- Toppings --}}
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Toppings</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach($toppings as $topping)
                        <label class="border rounded-lg p-3 bg-gray-50 text-center shadow cursor-pointer w-32">
                            <input type="checkbox" name="toppings[]" value="{{ $topping->id }}" class="mb-2">
                            <img src="{{ asset('storage/' . $topping->img) }}" class="w-24 h-20 rounded-lg object-cover mx-auto mb-1">
                            <p class="text-sm font-semibold">{{ $topping->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $topping->price }} EGP</p>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Side Options --}}
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Side Options</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach($side_options as $side)
                        <label class="border rounded-lg p-3 bg-gray-50 text-center shadow cursor-pointer w-32">
                            <input type="checkbox" name="side_options[]" value="{{ $side->id }}" class="mb-2">
                            <img src="{{ asset('storage/' . $side->img) }}" class="w-24 h-20 rounded-lg object-cover mx-auto mb-1">
                            <p class="text-sm font-semibold">{{ $side->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $side->price }} EGP</p>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- الأزرار --}}
            <div class="flex items-center gap-4 mt-6">
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Save Options
                </button>

                <a href="{{ route('cart.index') }}"
                   class="px-6 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">
                   Back to Cart
                </a>
            </div>
        </form>

    </div>

</x-app-layout>
