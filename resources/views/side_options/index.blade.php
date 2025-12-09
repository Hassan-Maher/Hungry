<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Side Options
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        @if(session('message'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <a href="{{ route('side_options.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">+ Add New</a>

        <div class="bg-white shadow-md rounded-xl p-6 mt-4">

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Price</th>
                        <th class="p-3 border">Image</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($side_options as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $index+1 }}</td>
                            <td class="p-3 border">{{ $item->name }}</td>
                            <td class="p-3 border">{{ $item->price }} EGP</td>

                            <td class="p-3 border">
                                <img src="{{ asset('storage/'.$item->img) }}"
                                class="w-16 h-16 rounded">
                            </td>

                            <td class="p-3 border text-center">

                                <a href="{{ route('side_options.edit', $item->id) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg">
                                    Edit
                                </a>

                                <form action="{{ route('side_options.destroy', $item->id) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Delete this item?');">

                                    @csrf
                                    @method('DELETE')

                                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">
                                        Delete
                                    </button>

                                </form>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="mt-4">
                {{ $side_options->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
