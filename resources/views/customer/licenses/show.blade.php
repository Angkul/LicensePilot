@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h2 class="text-xl font-bold mb-4">🔑 License Detail</h2>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Key:</strong> {{ $license->license_key }}</p>
        <p><strong>Status:</strong> {{ $license->status }}</p>
        <p><strong>Max Activations:</strong> {{ $license->max_activations }}</p>
        <p><strong>Expires:</strong> {{ $license->expires_at }}</p>

        <h4 class="mt-4 font-semibold">Activations:</h4>
        @if ($license->activations && is_array($license->activations) && count($license->activations))
            <ul class="list-disc ml-6 mt-2">
                @foreach ($license->activations as $activation)
                    <li>{{ $activation['domain'] ?? 'N/A' }} — {{ $activation['ip'] ?? 'N/A' }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No activations.</p>
        @endif
    </div>
</div>
@endsection
