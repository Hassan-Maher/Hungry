<div class="mb-4">
    <label class="block mb-1 font-semibold">Code</label>
    <input type="text" name="code"
        class="w-full border rounded p-2"
        value="{{ old('code', $coupon->code ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Type</label>
    <select name="type" class="w-full border rounded p-2">
        <option value="precentage" {{ old('type', $coupon->type ?? '') == 'precentage' ? 'selected' : '' }}>
            Precentage
        </option>
        <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>
            Fixed
        </option>
    </select>
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Discount Value</label>
    <input type="number" name="discount_value" step="0.01"
        class="w-full border rounded p-2"
        value="{{ old('discount_value', $coupon->discount_value ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Max Uses</label>
    <input type="number" name="max_uses"
        class="w-full border rounded p-2"
        value="{{ old('max_uses', $coupon->max_uses ?? '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Expires At</label>
    <input type="datetime-local" name="expires_at"
        class="w-full border rounded p-2"
        value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
</div>

<div class="mb-4">
    <label class="block mb-1 font-semibold">Status</label>
    <select name="status" class="w-full border rounded p-2">
        <option value="active" {{ old('status', $coupon->status ?? '') == 'active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="in_active" {{ old('status', $coupon->status ?? '') == 'in_active' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>
