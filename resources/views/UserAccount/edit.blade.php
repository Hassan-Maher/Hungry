<!-- resources/views/account/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Account
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">
        @if (session('message'))
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
                {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('UserAccount.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" class="w-full border rounded-lg p-2">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Update
                </button>
            </div>
        </form>

        <!-- Change Password Section -->
        <hr class="my-6">
        <h3 class="text-lg font-semibold mb-2">Change Password</h3>

        <form action="{{ route('UserAccount.update_password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">New Password</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
