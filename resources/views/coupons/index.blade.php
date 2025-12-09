<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Coupons
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        {{-- زرار إضافة كوبون --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('coupons.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Coupon
            </a>
        </div>

        {{-- جدول الكوبونات --}}
        <div class="bg-white shadow-md rounded-xl p-6">

            <h3 class="text-xl font-semibold mb-4">Coupons List</h3>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Code</th>
                        <th class="p-3 border">Type</th>
                        <th class="p-3 border">Value</th>
                        <th class="p-3 border">Max Uses</th>
                        <th class="p-3 border">Used</th>
                        <th class="p-3 border">Expire Date</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($coupons as $index => $coupon)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 border">{{ $index + 1 }}</td>
                            <td class="p-3 border">{{ $coupon->code }}</td>
                            <td class="p-3 border">{{ ucfirst($coupon->type) }}</td>
                            <td class="p-3 border">{{ $coupon->discount_value }}</td>
                            <td class="p-3 border">{{ $coupon->max_uses ?? '∞' }}</td>
                            <td class="p-3 border">{{ $coupon->uses_count }}</td>
                            <td class="p-3 border">
                                {{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d | h:i A') : 'No Expiry' }}
                            </td>

                            <td class="p-3 border">
                                <span class="px-2 py-1 rounded text-white
                                    @if($coupon->status == 'active') bg-green-600
                                    @else bg-gray-600 @endif">
                                    {{ ucfirst($coupon->status) }}
                                </span>
                            </td>

                            <td class="p-3 border text-center">
                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                    class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('coupons.destroy', $coupon->id) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Delete this coupon?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>
