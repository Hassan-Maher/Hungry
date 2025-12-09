<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Coupon
        </h2>
    </x-slot>
               @if (session('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 w-1/2 mx-auto text-center">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="max-w-3xl mx-auto mt-6 bg-white shadow-md rounded-xl p-6">

        <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('coupons.form', ['coupon' => $coupon])

            <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </form>

    </div>

</x-app-layout>
