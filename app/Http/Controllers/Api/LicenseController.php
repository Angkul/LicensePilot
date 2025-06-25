<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function validate(Request $request)
    {
        $licenseKey = $request->input('license_key');
        $domain = $request->input('domain');
        $ip = $request->ip();

        $license = License::where('license_key', $licenseKey)->first();

        if (! $license || $license->status !== 'active') {
            return response()->json(['valid' => false, 'message' => 'Invalid or inactive license.'], 403);
        }

        if ($license->expires_at && now()->gt($license->expires_at)) {
            return response()->json(['valid' => false, 'message' => 'License has expired.'], 403);
        }

        $activations = collect($license->activations ?? []);
        $exists = $activations->firstWhere('domain', $domain) ?? $activations->firstWhere('ip', $ip);

        if (! $exists) {
            if ($activations->count() >= $license->max_activations) {
                return response()->json(['valid' => false, 'message' => 'Activation limit reached.'], 403);
            }

            $activations->push([
                'domain' => $domain,
                'ip' => $ip,
                'activated_at' => now()->toDateTimeString(),
            ]);

            $license->activations = $activations;
            $license->save();
        }

        return response()->json([
            'valid' => true,
            'message' => 'License is valid.',
            'data' => [
                'license_key' => $license->license_key,
                'product_slug' => $license->product_slug,
                'expires_at' => $license->expires_at,
                'max_activations' => $license->max_activations,
            ],
        ]);
    }

    public function deactivate(Request $request)
    {
        $licenseKey = $request->input('license_key');
        $domain = $request->input('domain');
        $ip = $request->ip();

        $license = License::where('license_key', $licenseKey)->first();

        if (! $license) {
            return response()->json(['success' => false, 'message' => 'License not found.'], 404);
        }

        $activations = collect($license->activations ?? []);
        $updated = $activations->reject(fn($entry) => $entry['domain'] === $domain || $entry['ip'] === $ip);

        $license->activations = $updated->values();
        $license->save();

        return response()->json([
            'success' => true,
            'message' => 'License deactivated successfully.',
            'remaining_activations' => $updated->count(),
        ]);
    }

    public function activations(Request $request)
    {
        $licenseKey = $request->input('license_key');

        $license = License::where('license_key', $licenseKey)->first();

        if (! $license) {
            return response()->json(['success' => false, 'message' => 'License not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'activations' => $license->activations ?? [],
            'used' => count($license->activations ?? []),
            'limit' => $license->max_activations,
        ]);
    }
}
