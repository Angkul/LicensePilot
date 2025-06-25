<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;

class DashboardController extends Controller
{
    public function index()
    {
        $licenses = License::orderByDesc('created_at')->paginate(10);
        return view('admin.dashboard', compact('licenses'));
    }
}
