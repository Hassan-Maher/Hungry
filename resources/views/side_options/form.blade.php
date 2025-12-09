<div class="mb-4">
    <label class="block mb-1 font-semibold">Name</label>
    <input type="text" name="name"
        class="w-full border rounded p-2"
        value="{{ old('name', $side_option->name ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Price</label>
    <input type="number" name="price" step="0.01"
        class="w-full border rounded p-2"
        value="{{ old('price', $side_option->price ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Image</label>

    <input type="file" name="img" class="w-full border rounded p-2">

    @isset($side_option)
        <p class="mt-2 text-sm text-gray-600">Current Image:</p>
        <img src="{{ asset('storage/'.$side_option->img) }}"
            class="w-20 h-20 rounded mt-2">
    @endisset
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
    {{ isset($side_option) ? 'Update' : 'Create' }}
</button>
