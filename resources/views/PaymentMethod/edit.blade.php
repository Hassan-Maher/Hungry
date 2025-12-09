<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Payment Method
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-10 bg-white shadow-md p-6 rounded-xl">

        <form method="POST" action="{{ route('payment_method.update', $method->id) }}">
            @csrf

            <label class="block font-semibold mb-1">Name:</label>
            <input type="text" name="name"
                value="{{ $method->name }}"
                class="w-full border p-2 rounded mb-4" required>

            <button class="w-full bg-yellow-600 text-white py-2 rounded hover:bg-yellow-700">
                Update
            </button>

        </form>

    </div>

</x-app-layout>
