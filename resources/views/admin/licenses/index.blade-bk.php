@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Domain(s)</th>
                <th>License Key</th>
                <th>Product</th>
                <th>Status</th>
                <th>Activations</th>
                <th>Expires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($licenses as $license)
                <tr>
                    <td>
                        @if (!empty($license->activations))
                            <ul class="mb-0">
                                @foreach ($license->activations as $activation)
                                    <li>{{ $activation['domain'] ?? '—' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>—</em>
                        @endif
                    </td>
                    <td>{{ $license->license_key }}</td>
                    <td>{{ $license->product_slug }}</td>
                    <td>{{ $license->status }}</td>

                    <td>
                        {{ is_array($license->activations) ? count($license->activations) : 0 }} / {{ $license->max_activations }}
                    </td>

                    <td>{{ $license->expires_at }}</td>
                    <td>
                        <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $licenses->links() }}
</div>
@endsection

