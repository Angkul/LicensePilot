@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">📋 Your License Keys</h2>

    @forelse ($licenses as $license)
        <div class="border rounded p-4 mb-4 shadow-sm bg-white">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $license->product_slug }}</h3>
                    <p class="text-gray-600">Key: <span class="font-mono text-blue-600">{{ $license->license_key }}</span></p>
                    <p class="text-sm">Status: <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded">{{ $license->status }}</span></p>
                    <p class="text-sm">Expires: {{ $license->expires_at }}</p>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('customer.licenses.show', $license) }}" class="text-sm text-indigo-600 hover:underline">View</a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">You have no license keys yet.</p>
    @endforelse
</div>
@endsection
