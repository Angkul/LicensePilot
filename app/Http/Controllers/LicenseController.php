<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;

class LicenseAdminController extends Controller
{
    public function validateLicense(Request $request)
    {
        $license = License::where('license_key', $request->license_key)->first();

        if (!$license || $license->status !== 'active') {
            return response()->json(['valid' => false, 'message' => 'Invalid or inactive license'], 200);
        }

        if ($license->expires_at && now()->greaterThan($license->expires_at)) {
            return response()->json(['valid' => false, 'message' => 'License expired'], 200);
        }

        return response()->json([
            'valid' => true,
            'expires_at' => $license->expires_at,
            'product' => $license->product_slug,
            'message' => 'License valid',
        ]);
    }

    public function activate(Request $request)
    {
        $license = License::where('license_key', $request->license_key)->first();
        if (!$license || $license->status !== 'active') {
            return response()->json(['valid' => false, 'message' => 'License not found or inactive'], 200);
        }

        $activations = collect(json_decode($license->activations, true) ?: []);

        if (!$activations->contains($request->site_url)) {
            if ($activations->count() >= $license->max_activations) {
                return response()->json(['valid' => false, 'message' => 'Maximum activations reached'], 200);
            }

            $activations->push($request->site_url);
            $license->activations = $activations;
            $license->save();
        }

        return response()->json(['valid' => true, 'message' => 'License activated']);
    }
}
