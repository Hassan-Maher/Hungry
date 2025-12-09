<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Cart
        </h2>
    </x-slot>

    {{-- Success Message --}}
    @if (session('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 w-1/2 mx-auto text-center">
            {{ session('message') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="max-w-5xl mx-auto mt-6">

        {{-- لو الكارت فاضية --}}
        @if (!$cart || $cart->items->count() == 0)
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <p class="text-gray-600 text-xl mb-3">Your cart is empty.</p>
                <p class="text-gray-500">Add some items to continue.</p>
            </div>
        @else

        {{-- السعر الكلي + زر Checkout --}}
        <div class="bg-white shadow-md rounded-xl p-5 mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">
                Total Cart Price:
                <span class="text-green-600">{{ $cart->price }} EGP</span>
            </h2>

            <a href="{{ route('order.summary') }}"
               class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 text-lg">
                Proceed to Checkout
            </a>
        </div>

        {{-- عرض كل المنتجات --}}
        @foreach ($cart->items as $item)
            <div class="bg-white shadow-md rounded-xl p-6 mb-6">

                <div class="flex justify-between items-center">

                    <div class="flex items-center gap-4">

                        {{-- صورة المنتج --}}
                        <img src="{{ asset('storage/' . $item->product->img) }}"
                            class="w-24 h-24 rounded-lg object-cover shadow">

                        {{-- بيانات المنتج --}}
                        <div>
                            <h3 class="text-xl font-semibold">{{ $item->product->name }}</h3>
                            <p class="text-gray-600">Price: {{ $item->price_of_product }} EGP</p>

                            {{-- كمية المنتج --}}
                            <div class="flex items-center gap-3 mt-2">
                                <form action="{{ route('cart_item.decrement', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="px-2 py-1 bg-gray-300 rounded">-</button>
                                </form>

                                <span class="text-gray-700 text-lg font-semibold">
                                    {{ $item->quantity }}
                                </span>

                                <form action="{{ route('cart_item.increment', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="px-2 py-1 bg-gray-300 rounded">+</button>
                                </form>
                            </div>

                            <p class="text-green-600 font-semibold mt-2">
                                Total: {{ $item->total_price }} EGP
                            </p>

                            {{-- زر Add Options --}}
                            <div class="mt-3">
                                <a href="{{ route('cart_option.create', $item->id) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                   Add Options
                                </a>
                            </div>

                        </div>

                    </div>

                    {{-- زر حذف المنتج --}}
                    <form action="{{ route('car_item.delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Remove
                        </button>
                    </form>

                </div>

                <hr class="my-4">

                {{-- Toppings --}}
                <div class="mb-2">
                    <h3 class="text-lg font-semibold">Toppings:</h3>
                    @if ($item->options->where('optionable_type', "App\Models\Topping")->count())
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach ($item->options->where('optionable_type', "App\Models\Topping") as $opt)
                                <div class="border rounded-lg p-3 bg-gray-50 text-center shadow">
                                    <p class="font-semibold">{{ $opt->optionable->name }}</p>
                                    <img src="{{ asset('storage/' . $opt->optionable->img) }}"
                                         class="w-24 h-20 rounded-lg object-cover shadow">
                                    <p class="text-gray-600 text-sm">{{ $opt->price }} EGP</p>

                                    <form action="{{ route('cart_option.delete', $opt->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mt-1">No toppings selected.</p>
                    @endif
                </div>

                {{-- Side Options --}}
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Side Options:</h3>
                    @if ($item->options->where('optionable_type', "App\Models\SideOption")->count())
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach ($item->options->where('optionable_type', "App\Models\SideOption") as $opt)
                                <div class="border rounded-lg p-3 bg-gray-50 text-center shadow">
                                    <p class="font-semibold">{{ $opt->optionable->name }}</p>
                                    <img src="{{ asset('storage/' . $opt->optionable->img) }}"
                                        class="w-24 h-20 rounded-lg object-cover shadow">
                                    <p class="text-gray-600 text-sm">{{ $opt->price }} EGP</p>

                                    <form action="{{ route('cart_option.delete', $opt->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mt-1">No side options selected.</p>
                    @endif
                </div>

            </div>
        @endforeach

        @endif {{-- نهاية شرط الكارت --}}
            
    </div>

</x-app-layout>
