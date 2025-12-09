<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Payment Method
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-10 bg-white shadow-md p-6 rounded-xl">

        <form method="POST" action="{{ route('payment_method.store') }}">
            @csrf

            <label class="block font-semibold mb-1">Name:</label>
            <input type="text" name="name"
                class="w-full border p-2 rounded mb-4"
                placeholder="Enter payment method name" required>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Save
            </button>

        </form>

    </div>

</x-app-layout>
