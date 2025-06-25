<?php

// app/Http/Controllers/Customer/CustomerLicenseController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLicenseController extends Controller
{
    public function index()
    {
        // ดึงเฉพาะ license ของผู้ใช้ที่ login อยู่
        $licenses = License::where('user_id', Auth::id())->get();

        return view('customer.licenses.index', compact('licenses'));
    }

    public function show(License $license)
    {
        // ป้องกันไม่ให้ดูของคนอื่น
        abort_unless($license->user_id === Auth::id(), 403);

        return view('customer.licenses.show', compact('license'));
    }
}
