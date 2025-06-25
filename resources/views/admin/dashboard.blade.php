{{--
  resources/views/admin/licenses/index.blade.php

  โค้ดนี้ถูกปรับปรุงโดยใช้ Tailwind CSS ตามโครงสร้างที่คุณให้มา
  - คงตัวแปรและ Logic เดิมทั้งหมด ($licenses, $license, $act, การนับ activations, การแสดง status).
  - เปลี่ยนจาก Bootstrap classes (.card, .table, .btn, .badge) มาเป็น Utility classes ของ Tailwind.
  - ดีไซน์โดยรวมถูกปรับให้ดูทันสมัยและสะอาดตาขึ้น.
  - เพิ่ม Header และปรับปรุงส่วน "No licenses found" เพื่อ UX ที่ดีขึ้น.
--}}

@extends('layouts.app')

@section('content')

<div>
    <div class="container mx-auto px-4">

        <!-- Page Header -->
        <div class="py-12">
            <h1 class="text-2xl font-bold text-gray-800">License Keys</h1>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-left text-sm font-semibold text-gray-600">
                            <th class="px-6 py-3">Domains</th>
                            <th class="px-6 py-3">Key</th>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Activations</th>
                            <th class="px-6 py-3">Expires</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($licenses as $license)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <!-- Domains -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @if (!empty($license->activations))
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($license->activations as $act)
                                                <li>{{ $act['domain'] ?? '—' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em class="text-gray-400">—</em>
                                    @endif
                                </td>

                                <!-- Key -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <code class="font-mono text-gray-800 bg-gray-100 px-2 py-1 rounded">{{ $license->license_key }}</code>
                                </td>

                                <!-- Product -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $license->product_slug }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($license->status === 'active')
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($license->status) }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-700">
                                            {{ ucfirst($license->status) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Activations -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ count($license->activations ?? []) }} / {{ $license->max_activations }}
                                </td>

                                <!-- Expires -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $license->expires_at ?? '—' }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <a href="{{ route('admin.licenses.show', $license) }}"
                                       class="px-3 py-1.5 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-500">
                                    <p>No licenses found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($licenses->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $licenses->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
