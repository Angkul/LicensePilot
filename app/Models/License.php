<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $casts = [
        'activations' => 'array',
        'expires_at' => 'datetime',
    ];

    // ✅ เพิ่มความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
