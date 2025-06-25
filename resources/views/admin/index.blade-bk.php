@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">License Keys</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Domains</th>
                        <th>Key</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Activations</th>
                        <th>Expires</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($licenses as $license)
                    <tr>
                        <td>
                            @if (!empty($license->activations))
                                <ul class="mb-0 ps-3">
                                    @foreach ($license->activations as $act)
                                        <li>{{ $act['domain'] ?? '—' }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>—</em>
                            @endif
                        </td>
                        <td><code>{{ $license->license_key }}</code></td>
                        <td>{{ $license->product_slug }}</td>
                        <td>
                            <span class="badge {{ $license->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($license->status) }}
                            </span>
                        </td>
                        <td>{{ count($license->activations ?? []) }} / {{ $license->max_activations }}</td>
                        <td>{{ $license->expires_at ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-3 text-muted">No licenses found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $licenses->links() }}
        </div>
    </div>
</div>
@endsection
