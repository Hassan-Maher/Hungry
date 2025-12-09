<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Toppings
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        <div class="flex justify-end mb-4">
            <a href="{{ route('toppings.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Topping
            </a>
        </div>

        <div class="bg-white shadow-md rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">Toppings List</h3>

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
                    @forelse($toppings as $index => $topping)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $index + 1 }}</td>

                            <td class="p-3 border">{{ $topping->name }}</td>

                            <td class="p-3 border">{{ $topping->price }} EGP</td>

                            <td class="p-3 border">
                                <img src="{{ asset('storage/'.$topping->img) }}" class="w-14 h-14 rounded object-cover">
                            </td>

                            <td class="p-3 border text-center">

                                <a href="{{ route('toppings.edit', $topping->id) }}"
                                   class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('toppings.destroy', $topping->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Delete topping?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No toppings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $toppings->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
