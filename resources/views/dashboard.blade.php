<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Overview
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Card -->
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <h3 class="text-gray-500 font-semibold">Total Users</h3>
                    <p class="text-4xl font-bold mt-2 text-gray-800">{{ $users_count ?? 0 }}</p>
                </div>

                <!-- Card -->
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <h3 class="text-gray-500 font-semibold">Active Users</h3>
                    <p class="text-4xl font-bold mt-2 text-gray-800">{{ $active_users ?? 0 }}</p>
                </div>

                <!-- Card -->
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <h3 class="text-gray-500 font-semibold">Blocked Users</h3>
                    <p class="text-4xl font-bold mt-2 text-gray-800">{{ $blocked_users ?? 0 }}</p>
                </div>

                <!-- Card -->
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <h3 class="text-gray-500 font-semibold">Total Products</h3>
                    <p class="text-4xl font-bold mt-2 text-gray-800">{{ $products_count ?? 0 }}</p>
                </div>

                <!-- Card -->
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <h3 class="text-gray-500 font-semibold">Orders</h3>
                    <p class="text-4xl font-bold mt-2 text-gray-800">{{ $orders_count ?? 0 }}</p>
                </div>

            </div>


        </div>
    </div>
</x-app-layout>

