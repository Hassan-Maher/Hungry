<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Methods
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        {{-- Success Message --}}
        @if(session('message'))
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center">
                {{ session('message') }}
            </div>
        @endif

        {{-- Create New --}}
        <div class="text-right mb-4">
            <a href="{{ route('payment_method.create') }}"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add New Payment Method
            </a>
        </div>

        {{-- Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            @foreach($payment_methods as $method)
                <div class="bg-white p-5 shadow-md rounded-xl border">

                    <h3 class="text-xl font-semibold mb-2">{{ $method->name }}</h3>

                    <p class="text-gray-700 mb-3">
                        <strong>Total Usage:</strong>
                        {{ $method->orders()->count() }}
                    </p>

                    <div class="flex justify-between mt-4">

                        <a href="{{ route('payment_method.edit', $method->id) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('payment_method.delete', $method->id) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this method?')"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</x-app-layout>
