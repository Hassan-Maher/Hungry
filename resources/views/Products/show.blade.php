<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Details
        </h2>
    </x-slot>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
@if (session('message'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('message') }}
    </div>
@endif


    <div class="max-w-5xl mx-auto mt-6">

        {{-- بطاقة بيانات المنتج --}}
        <div class="bg-white shadow-md rounded-xl p-6 mb-8">

            <div class="flex flex-col md:flex-row gap-6">

                {{-- صورة المنتج --}}
                <div>
                    <img src="{{ asset('storage/' . $product->img) }}"
                        class="w-48 h-48 object-cover rounded-lg shadow">
                </div>

                {{-- التفاصيل --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

                    <p class="text-gray-700 mb-2">
                        <strong>Category:</strong> {{ $product->category->name }}
                    </p>

                    <p class="text-xl text-green-600 font-semibold mb-4">
                        Price: {{ $product->price }} EGP
                    </p>

                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description ?? "No description available." }}
                    </p>
                </div>

            </div>
        </div>


        {{-- فورم إضافة للسلة --}}
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            {{-- قسم الـ Toppings --}}
            <div class="bg-white shadow-md rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-semibold mb-4">Choose Toppings</h2>

                @if($toppings->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($toppings as $top)
                            <label class="border rounded-xl p-4 cursor-pointer hover:shadow-lg transition bg-gray-50 block">

                                <input 
                                    type="checkbox" 
                                    name="toppings[]" 
                                    value="{{ $top->id }}" 
                                    class="mb-3">

                                <img src="{{ asset('storage/' . $top->img) }}"
                                    class="w-24 h-24 mx-auto rounded-lg object-cover mb-3">

                                <h3 class="font-semibold text-gray-800">{{ $top->name }}</h3>

                                <p class="text-gray-600 text-sm">
                                    {{ $top->price }} EGP
                                </p>

                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No toppings available.</p>
                @endif
            </div>


            {{-- قسم الـ Side Options --}}
            <div class="bg-white shadow-md rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-semibold mb-4">Choose Side Options</h2>

                @if($side_options->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($side_options as $side)
                            <label class="border rounded-xl p-4 cursor-pointer hover:shadow-lg transition bg-gray-50 block">

                                <input 
                                    type="checkbox" 
                                    name="side_options[]" 
                                    value="{{ $side->id }}" 
                                    class="mb-3">

                                <img src="{{ asset('storage/' . $side->img) }}"
                                    class="w-24 h-24 mx-auto rounded-lg object-cover mb-3">

                                <h3 class="font-semibold text-gray-800">{{ $side->name }}</h3>

                                <p class="text-gray-600 text-sm">
                                    {{ $side->price }} EGP
                                </p>

                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No side options available.</p>
                @endif
            </div>

            {{-- اختيار الكمية --}}
            <div class="bg-white shadow-md rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-semibold mb-4">Quantity</h2>

                <div class="w-40">
                    <input 
                        type="number" 
                        name="quantity" 
                        min="1" 
                        value="1"
                        class="w-full border rounded-lg p-3 text-lg"
                        required>
                </div>
            </div>

            {{-- زر إضافة للسلة --}}
            <div class="text-center mt-6 mb-10">
                <button 
                    type="submit"
                    class="px-8 py-3 bg-indigo-600 text-white text-lg rounded-lg hover:bg-indigo-700 transition">
                    + Add To Cart
                </button>
            </div>

        </form>


        {{-- زر الرجوع --}}
        <div class="text-center mt-3">
            <a href="{{ route('products.index') }}"
               class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                ← Back to Products
            </a>
        </div>

    </div>

</x-app-layout>
