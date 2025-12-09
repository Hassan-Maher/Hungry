<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    

    <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen px-4 py-6">
            <h2 class="text-lg font-bold mb-6">Dashboard</h2>
            <ul class="space-y-4">
                <li><a href="{{ route('dashboard')}}" class="hover:text-gray-300">Home</a></li>
                <li><a href="{{ route('users.index')}}" class="hover:text-gray-300">Users</a></li>
                <li><a href="{{ route('products.index')}}" class="hover:text-gray-300">Products</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-gray-300">Cart</a></li>
                <li><a href="{{ route('AdminOrders.index')}}" class="hover:text-gray-300">My Orders</a></li>
                <li><a href="{{ route('orders.index') }}" class="hover:text-gray-300">Orders</a></li>
                <li><a href="{{ route('payment_method.index')}}" class="hover:text-gray-300">Payment Methods</a></li>
                <li><a href="{{ route('coupons.index')}}" class="hover:text-gray-300">Coupons</a></li>
                <li><a href="{{ route('toppings.index')}}" class="hover:text-gray-300">Toppings</a></li>
                <li><a href="{{ route('side_options.index')}}" class="hover:text-gray-300">Side_Options</a></li>
                <li><a href="{{ route('UserAccount.edit')}}" class="hover:text-gray-300">UserAccount</a></li>
            </ul>
        </aside>

        <!-- Content -->
        <div class="flex-1">

            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

    </div>
</body>

</html>
