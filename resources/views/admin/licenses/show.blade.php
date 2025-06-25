<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Details</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN for interactive components (like modal) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom font for a clean look - Using a more common sans-serif stack to match typical web UIs */
        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f8fafc; /* Light background for the page */
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <!-- Main container for the entire page content -->
    <!-- Using Alpine.js for modal state management, and copy feedback -->
    <div x-data="{ showModal: false, formToSubmit: null, modalMessage: '', confirmButtonText: 'ยืนยัน', cancelButtonText: 'ยกเลิก', showCopyFeedback: false }"
         class="min-h-screen flex flex-col items-center justify-start p-4">
        <!-- Back Button -->
        <div class="w-full max-w-4xl flex justify-start mb-6 mt-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                ย้อนกลับ
            </a>
        </div>

        <!-- Card wrapper for the license details, applying the requested border and radius -->
        <div class="w-full max-w-4xl bg-gray-50 border border-gray-200 rounded-[15px] shadow-lg p-6 lg:p-8 mb-8">

            <!-- License Key Header and Copy Button -->
            <div class="flex items-center justify-between flex-wrap gap-4 mb-6 border-b pb-4">
                <h3 class="text-3xl lg:text-4xl font-extrabold text-gray-900 break-all flex-grow">
                    License Key: <span id="licenseKeyToCopy" class="text-indigo-700">{{ $license->license_key }}</span>
                </h3>
                <div class="relative">
                    <button type="button"
                            @click="
                                const licenseKey = document.getElementById('licenseKeyToCopy').innerText;
                                const tempInput = document.createElement('textarea');
                                tempInput.value = licenseKey;
                                document.body.appendChild(tempInput);
                                tempInput.select();
                                document.execCommand('copy');
                                document.body.removeChild(tempInput);
                                showCopyFeedback = true;
                                setTimeout(() => showCopyFeedback = false, 2000);
                            "
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m-3-5l4 4m-4-4l-4 4m4-4V5M9 7h6"></path></svg>
                        Copy
                    </button>
                    <!-- Copy Feedback Message -->
                    <span x-show="showCopyFeedback"
                          x-transition:enter="transition ease-out duration-300"
                          x-transition:enter-start="opacity-0 translate-y-2"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          x-transition:leave="transition ease-in duration-200"
                          x-transition:leave-start="opacity-100 translate-y-0"
                          x-transition:leave-end="opacity-0 translate-y-2"
                          class="absolute top-full left-1/2 -translate-x-1/2 mt-2 px-3 py-1 bg-gray-700 text-white text-xs rounded-md shadow-lg whitespace-nowrap">
                        Copied!
                    </span>
                </div>
            </div>

            <!-- License Details Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Status Card -->
                <div class="p-5 bg-white rounded-lg shadow-sm border border-gray-100">
                    <p class="text-lg text-gray-700">
                        <strong class="font-semibold text-gray-800">Status:</strong>
                        @if ($license->status === 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @elseif ($license->status === 'expired')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Expired
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ ucfirst($license->status) }}
                            </span>
                        @endif
                    </p>
                </div>

                <!-- Max Activations Card -->
                <div class="p-5 bg-white rounded-lg shadow-sm border border-gray-100">
                    <p class="text-lg text-gray-700">
                        <strong class="font-semibold text-gray-800">Max Activations:</strong>
                        <span class="font-medium text-gray-900">{{ $license->max_activations }}</span>
                    </p>
                </div>

                <!-- Expires At Card -->
                <div class="p-5 bg-white rounded-lg shadow-sm border border-gray-100">
                    <p class="text-lg text-gray-700">
                        <strong class="font-semibold text-gray-800">Expires At:</strong>
                        <span class="font-medium text-gray-900">{{ $license->expires_at ? \Carbon\Carbon::parse($license->expires_at)->format('d M Y H:i') : 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <!-- Activations Section Header -->
            <h4 class="text-2xl font-bold text-gray-800 mt-8 mb-4 border-b pb-3">
                Activations
            </h4>

            @if ($license->activations && is_array($license->activations) && count($license->activations) > 0)
                <!-- Activations List -->
                <div class="space-y-4">
                    @foreach ($license->activations as $activation)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex items-center text-gray-700 mb-3 sm:mb-0">
                                <span class="text-xl mr-2">🔗</span>
                                <span class="font-medium break-all">{{ $activation['domain'] ?? 'N/A' }}</span>
                                <span class="mx-2 text-gray-400">—</span>
                                <span class="text-sm text-gray-500">{{ $activation['ip'] ?? 'N/A' }}</span>
                            </div>
                            <!-- Deactivate Form - Using a type="button" to trigger the modal -->
                            <form id="deactivate-{{ $loop->index }}-form" method="POST" action="{{ route('admin.licenses.deactivate', $license) }}" class="inline-block">
                                @csrf
                                <input type="hidden" name="domain" value="{{ $activation['domain'] ?? '' }}">
                                <button type="button"
                                        @click="showModal = true; formToSubmit = $event.target.closest('form'); modalMessage = 'ยืนยันยกเลิกการเปิดใช้งานบน {{ $activation['domain'] ?? 'N/A' }} ใช่ไหม?'; confirmButtonText='ยืนยันยกเลิก';"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full sm:w-auto">
                                    Deactivate
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Activations Message -->
                <p class="text-gray-600 italic p-4 bg-white rounded-lg shadow-sm border border-gray-100">No activations yet.</p>
            @endif

            <!-- Delete License Button and Form -->
            <div class="mt-10 pt-6 border-t border-gray-200 flex justify-center">
                <form id="delete-license-form" method="POST" action="{{ route('admin.licenses.destroy', $license) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            @click="showModal = true; formToSubmit = $event.target.closest('form'); modalMessage = 'คุณแน่ใจหรือไม่ว่าต้องการลบ License นี้? การดำเนินการนี้ไม่สามารถย้อนกลับได้'; confirmButtonText='ลบ';"
                            class="bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 flex items-center">
                        <span class="mr-2">🗑</span> ลบ License นี้
                    </button>
                </form>
            </div>

        </div>

        <!-- Custom Confirmation Modal (using Alpine.js) -->
        <div x-show="showModal"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" role="dialog" aria-modal="true"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This is to horizontally center the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Dialog -->
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Warning Icon (Exclamation mark) -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    ยืนยันการดำเนินการ
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500" x-text="modalMessage"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                @click="formToSubmit && formToSubmit.submit(); showModal = false;"
                                :class="{'bg-red-600 hover:bg-red-700 focus:ring-red-500': true, 'bg-gray-600': false}"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            <span x-text="confirmButtonText"></span>
                        </button>
                        <button type="button"
                                @click="showModal = false; formToSubmit = null;"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            <span x-text="cancelButtonText"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
