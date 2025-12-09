<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Product
        </h2>
    </x-slot>
                @if (session('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 w-1/2 mx-auto text-center">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-8">

            {{-- عنوان الصفحة --}}
            <h3 class="text-2xl font-bold mb-6 text-gray-700">Add New Product</h3>

            {{-- الفورم --}}
            <form action="{{ route('products.store') }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="space-y-6">

                @csrf
                {{-- اسم المنتج --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" name="name" 
                        class="w-full p-3 border rounded-lg focus:ring-indigo-300"
                        placeholder="Enter product name" value="{{ old('name') }}">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- الوصف --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="4"
                            class="w-full p-3 border rounded-lg focus:ring-indigo-300"
                            placeholder="Write product description...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- السعر --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" step="0.01" name="price"
                        class="w-full p-3 border rounded-lg focus:ring-indigo-300"
                        placeholder="Enter price" value="{{ old('price') }}">
                    @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- الكاتيجوري --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="category_id"
                            class="w-full p-3 border rounded-lg focus:ring-indigo-300">
                        <option value="">Choose category...</option>

                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- الصورة --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Product Image</label>
                    <input type="file" name="img"
                        class="w-full p-3 border rounded-lg bg-gray-50">
                    @error('img') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- الزرار --}}
                <div class="text-right">
                    <button class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Create Product
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>
