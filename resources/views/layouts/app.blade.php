{{--
  resources/views/layouts/app.blade.php

  ไฟล์ Layout ที่แก้ไขใหม่นี้มีการเปลี่ยนแปลงดังนี้:
  1.  **ลบ Bootstrap:** ตัด <link> ของ Bootstrap CSS ออก เพื่อป้องกันการทับซ้อนของสไตล์กับ Tailwind CSS
  2.  **โครงสร้างสำหรับ Tailwind:** ใช้โครงสร้าง body และ div.min-h-screen.bg-gray-100 ที่เป็นมาตรฐานสำหรับ Laravel ที่ใช้ Tailwind
  3.  **แก้ไขตำแหน่ง @yield:** ย้าย @yield('content') มาไว้ในแท็ก <main> ซึ่งเป็นตำแหน่งที่ถูกต้องสำหรับเนื้อหาหลักของหน้า ทำให้คลาสของ Tailwind ที่ใช้ใน view ของคุณ (เช่น max-w-7xl, mx-auto) ทำงานได้อย่างถูกต้อง
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>


        <!-- Google Fonts: Noto Sans Thai -->
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;700&display=swap" rel="stylesheet">


        <!-- Scripts (Vite handles CSS and JS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-800 bg-gray-50">
        <div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header>
                    <div>
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- @yield('content') is now correctly placed here --}}
                @yield('content')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
