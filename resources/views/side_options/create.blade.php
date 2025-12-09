<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Side Option
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-8 bg-white shadow-md p-6 rounded-xl">

        <form action="{{ route('side_options.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('side_options.form')

        </form>

    </div>

</x-app-layout>
