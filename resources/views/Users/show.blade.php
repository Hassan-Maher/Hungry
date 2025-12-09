<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Data
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- ========== بيانات المستخدم الشخصية ========== -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-700"> personal Data</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">

                    <div>
                        <p class="font-semibold">name:</p>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="font-semibold"> Email:</p>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="font-semibold"> address:</p>
                        <p>{{ $user->address ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="font-semibold">status:</p>
                        <p>
                            @if($user->is_bolcked)
                                <span class="px-2 py-1 bg-red-500 text-white rounded">محظور</span>
                            @else
                                <span class="px-2 py-1 bg-green-500 text-white rounded">نشط</span>
                            @endif
                        </p>
                    </div>

                </div>
            </div>

            <!-- ========== عدد الأوردرات ========== -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-xl font-semibold text-gray-700"> Orders Count</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $orders_count }}</p>
            </div>

            <!-- ========== جدول الأوردرات ========== -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Orders</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-3 text-left">#</th>
                                <th class="p-3 text-left">ID</th>
                                <th class="p-3 text-left">Price</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Date</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $index=>  $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ $index++ }}</td>
                                    <td class="p-3">{{ $order->id }}</td>
                                    <td class="p-3">{{ $order->price }} جنيه</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded 
                                            @if($order->status == 'paid') bg-green-500 text-white 
                                            @elseif($order->status == 'pending') bg-yellow-500 text-white
                                            @else bg-red-500 text-white @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ $order->created_at }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('order.show' , $order->id) }}"
                                            class="text-blue-600 hover:underline">
                                            عرض
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center text-gray-500">
                                        لا يوجد طلبات حالياً
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
