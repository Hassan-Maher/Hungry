<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->id }} Details
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">

        {{-- SECTION 1: Order Info --}}
        <div class="bg-white shadow-md rounded-xl p-6 mb-8">

            <h3 class="text-2xl font-semibold mb-4">Order Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><strong>Total Price:</strong> {{ $order->total_price }} EGP</p>

                <p>
                    <strong>Status:</strong>
                    <span class="px-2 py-1 rounded text-white
                        @if($order->status == 'pending') bg-yellow-500
                        @elseif($order->status == 'paid') bg-green-600
                        @elseif($order->status == 'rejected') bg-red-600
                        @else bg-gray-600 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                <p><strong>Payment Method:</strong> {{ $order->payment_method->name ?? '—' }}</p>

                <p><strong>Items Count:</strong> {{ $order->items->count() }}</p>

                <p><strong>Phone:</strong> {{ $order->phone ?? '—' }}</p>

                <p><strong>Address:</strong> {{ $order->address ?? 'No Address Provided' }}</p>

                <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d | h:i A') }}</p>

            </div>

        </div>


        {{-- SECTION 2: User Info --}}
        <div class="bg-white shadow-md rounded-xl p-6 mb-8">

            <h3 class="text-2xl font-semibold mb-4">User Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <p><strong>Name:</strong> {{ $order->user->name }}</p>

                <p><strong>Email:</strong> {{ $order->user->email }}</p>

                <p><strong>Phone:</strong> {{ $order->user->phone ?? '—' }}</p>

                <p><strong>Address:</strong> {{ $order->user->address ?? '—' }}</p>

            </div>

        </div>


        {{-- SECTION 3: Order Items --}}
        <div class="bg-white shadow-md rounded-xl p-6">

            <h3 class="text-2xl font-semibold mb-4">Order Items</h3>

            @foreach ($order->items as $item)

                <div class="border rounded-xl p-5 mb-6 shadow-sm">

                    <div class="flex items-start gap-4">

                        <img src="{{ asset('storage/' . $item->product->img) }}"
                             class="w-24 h-24 rounded-lg object-cover shadow">

                        <div class="w-full">

                            <h4 class="text-xl font-semibold">{{ $item->product->name }}</h4>
                            <p class="text-gray-600">Unit Price: {{ $item->price_of_product }} EGP</p>
                            <p class="text-gray-700 font-semibold">Quantity: {{ $item->quantity }}</p>
                            <p class="text-green-600 font-semibold mt-1">
                                Total: {{ $item->total_price }} EGP
                            </p>

                            <hr class="my-3">

                            {{-- Toppings --}}
                            <h4 class="text-lg font-semibold">Toppings:</h4>

                            @if ($item->options->where('optionable_type', "App\Models\Topping")->count())
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach ($item->options->where('optionable_type', "App\Models\Topping") as $opt)
                                        <div class="border rounded-lg p-3 bg-gray-50 text-center shadow">
                                            <p class="font-semibold">{{ $opt->optionable->name }}</p>
                                            <img src="{{ asset('storage/' . $opt->optionable->img) }}"
                                                 class="w-20 h-16 rounded-lg object-cover shadow">
                                            <p class="text-gray-600 text-sm">{{ $opt->price }} EGP</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 mt-1">No toppings selected.</p>
                            @endif


                            {{-- Side Options --}}
                            <h4 class="text-lg font-semibold mt-4">Side Options:</h4>

                            @if ($item->options->where('optionable_type', "App\Models\SideOption")->count())
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach ($item->options->where('optionable_type', "App\Models\SideOption") as $opt)
                                        <div class="border rounded-lg p-3 bg-gray-50 text-center shadow">
                                            <p class="font-semibold">{{ $opt->optionable->name }}</p>
                                            <img src="{{ asset('storage/' . $opt->optionable->img) }}"
                                                 class="w-20 h-16 rounded-lg object-cover shadow">
                                            <p class="text-gray-600 text-sm">{{ $opt->price }} EGP</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 mt-1">No side options selected.</p>
                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-app-layout>
