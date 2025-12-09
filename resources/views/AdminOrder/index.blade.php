<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Orders
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        {{-- كروت الاحصائيات --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            
            {{-- Total Orders --}}
            <div class="bg-white shadow-md rounded-xl p-5 text-center">
                <h3 class="text-lg font-semibold text-gray-600">Total Orders</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $orders_count }}</p>
            </div>

            {{-- Pending Orders --}}
            <div class="bg-white shadow-md rounded-xl p-5 text-center">
                <h3 class="text-lg font-semibold text-gray-600">Pending</h3>
                <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $pending_orders }}</p>
            </div>

            {{-- Success Orders --}}
            <div class="bg-white shadow-md rounded-xl p-5 text-center">
                <h3 class="text-lg font-semibold text-gray-600">Success</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $success_orders }}</p>
            </div>

            {{-- Failed Orders --}}
            <div class="bg-white shadow-md rounded-xl p-5 text-center">
                <h3 class="text-lg font-semibold text-gray-600">Failed</h3>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $failed_orders }}</p>
            </div>

        </div>

        {{-- جدول الطلبات --}}
        <div class="bg-white shadow-md rounded-xl p-6">

            <h3 class="text-xl font-semibold mb-4">Orders List</h3>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Price</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Created At</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $index =>  $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $index+1 }}</td>
                            <td class="p-3 border">{{ $order->id }}</td>
                            <td class="p-3 border">{{ $order->total_price }} EGP</td>
                            <td class="p-3 border">
                                <span class="px-2 py-1 rounded text-white
                                    @if($order->status == 'pending') bg-yellow-500
                                    @elseif($order->status == 'paid') bg-green-600
                                    @elseif($order->status == 'rejected') bg-red-600
                                    @else bg-gray-600 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td class="p-3 border">{{ $order->created_at->format('Y-m-d | h:i A') }}</td>

                            <td class="p-3 border text-center">
                                <a href="{{ route('order.show' , $order->id) }}"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-600">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $orders->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
