<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products Page
            </h2>
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


            {{-- زر إضافة منتج --}}
            <a href="{{ route('products.create') }}" 
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                + Add New Product
            </a>
        </div>
    </x-slot>

    {{-- الكروت --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
        <div class="bg-white shadow-md rounded-xl p-6 text-center border hover:shadow-xl transition">
            <h5 class="text-gray-500 text-lg">Total Products</h5>
            <h2 class="text-4xl font-bold text-gray-800 mt-2">{{ $products_count ?? 0 }}</h2>
        </div>
    </div>

    {{-- القسم الأساسي --}}
    <div class="bg-white shadow-md rounded-xl overflow-hidden">

        {{-- الهيدر + البحث --}}
        <div class="flex flex-col md:flex-row justify-between items-center px-6 py-4 bg-gray-100">

            <h5 class="text-lg font-semibold text-gray-600">Products List</h5>

            <form action="{{ route('products.index') }}" method="GET" class="flex mt-3 md:mt-0">
                <input 
                    type="text" 
                    name="search"
                    class="px-4 py-2 rounded-l-full border border-gray-300 focus:ring focus:ring-indigo-300"
                    placeholder="🔍 ابحث بالاسم او السعر ..."
                    value="{{ request('search') }}"
                >

                <button 
                    class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-r-full hover:bg-indigo-700 transition">
                    بحث
                </button>

                @if(request()->search)
                    <a href="{{ route('products.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        مسح
                    </a>
                @endif
            </form>
        </div>

        {{-- الجدول --}}
        <div class="overflow-x-auto">
            <table class="w-full text-center">
                <thead class="bg-gray-200">
                    <tr class="text-gray-700">
                        <th class="py-3 px-4 border">#</th>
                        <th class="py-3 px-4 border">Name</th>
                        <th class="py-3 px-4 border">Category</th>
                        <th class="py-3 px-4 border">Price</th>
                        <th class="py-3 px-4 border">Image</th>
                        <th class="py-3 px-4 border">Operation</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $index => $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 border">{{ $index + 1 }}</td>

                            <td class="py-3 px-4 border">{{ $product->name }}</td>

                            <td class="py-3 px-4 border">{{ $product->category->name }}</td>

                            <td class="py-3 px-4 border">{{ $product->price }} pound</td>

                            {{-- الصورة --}}
                            <td class="py-3 px-4 border">
                                <img src="{{ asset('storage/' . $product->img) }}" 
                                    class="w-16 h-16 object-cover rounded-lg mx-auto shadow">
                            </td>

                            {{-- العمليات --}}
                            <td class="py-3 px-4 border space-x-2">

                                {{-- زرار show --}}
                                <a href="{{ route('products.show' , $product->id) }}"
                                    class="px-3 py-1 border rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                    show
                                </a>

                                {{-- زرار edit --}}
                                <a href="{{ route('products.edit' , $product->id) }}"
                                    class="px-3 py-1 border rounded-lg text-indigo-600 hover:bg-indigo-50 transition">
                                    edit
                                </a>

                                {{-- زرار delete --}}
                                <form action="{{ route('products.delete' , $product->id) }}" 
                                    method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        type="submit"
                                        onclick="return confirm('هل أنت متأكد من حذف المنتج؟')"
                                        class="px-3 py-1 border rounded-lg text-red-600 hover:bg-red-50 transition">
                                        delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="py-5 text-gray-500">لا يوجد منتجات حاليًا</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $products->links() }}
        </div>

    </div>

</x-app-layout>
