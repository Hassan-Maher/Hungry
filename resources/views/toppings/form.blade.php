<div class="mb-4">
    <label class="block mb-1 font-semibold">Name</label>
    <input type="text" name="name"
        class="w-full border rounded p-2"
        value="{{ old('name', $topping->name ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Price</label>
    <input type="number" name="price" step="0.01"
        class="w-full border rounded p-2"
        value="{{ old('price', $topping->price ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Image</label>

    <input type="file" name="img"
        class="w-full border rounded p-2">

    @isset($topping)
        <p class="mt-2 text-sm text-gray-600">Current:</p>
        <img src="{{ asset('storage/'.$topping->img) }}" class="w-20 h-20 rounded mt-2"
        value = "{{ old('img' , $topping->img) }}">
    @endisset
</div>
