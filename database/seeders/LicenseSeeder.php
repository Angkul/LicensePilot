<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class LicenseSeeder extends Seeder
{
    public function run(): void
    {
        // ดึงหรือสร้าง user สำหรับ license
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'), // หรือเปลี่ยนตามต้องการ
            ]
        );

        // เพิ่ม license ใหม่ และผูกกับ user นี้
        DB::table('licenses')->insert([
            'license_key'     => 'TEST-ABC-123',
            'email'           => 'user@example.com',
            'product_slug'    => 'solar-rooftop-estimator',
            'status'          => 'active',
            'max_activations' => 3,
            'expires_at'      => now()->addYear(),
            'activations'     => json_encode([]),
            'user_id'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
