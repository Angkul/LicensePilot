<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseAdminController extends Controller
{
    public function index()
    {
        $licenses = License::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.licenses.index', compact('licenses'));
    }

    public function show(License $license)
    {
        return view('admin.licenses.show', compact('license'));
    }

    public function destroy(License $license)
    {
        $license->delete();
        return redirect()->route('admin.licenses.index')->with('success', 'License deleted.');
    }

    public function deactivate(Request $request, License $license)
    {
        $targetDomain = $request->input('domain');
        $activations = $license->activations ?? [];

        $filtered = collect($activations)->reject(function ($item) use ($targetDomain) {
            return isset($item['domain']) && $item['domain'] === $targetDomain;
        })->values();

        $license->activations = $filtered;
        $license->save();

        return back()->with('success', "Deactivated domain: {$targetDomain}");
    }

    public function create()
    {
        return view('admin.licenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_key' => 'required|unique:licenses,license_key',
            'product_slug' => 'required|string',
            'max_activations' => 'required|integer|min:1',
            'expires_at' => 'required|date',
        ]);

        License::create(array_merge($validated, ['status' => 'active']));

        return redirect()->route('admin.dashboard')->with('success', 'License created successfully.');
    }
}
