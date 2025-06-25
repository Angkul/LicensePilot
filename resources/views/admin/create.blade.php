@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">🆕 Create New License</h2>
    <form action="{{ route('admin.licenses.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">License Key</label>
            <input type="text" name="license_key" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Slug</label>
            <input type="text" name="product_slug" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Max Activations</label>
            <input type="number" name="max_activations" min="1" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Expires At</label>
            <input type="datetime-local" name="expires_at" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="bg-[#b89c88] text-white px-4 py-2 rounded hover:bg-[#a5856f] transition">Create</button>
    </form>
</div>
@endsection
