<?php

namespace App\Http\Controllers;

use App\Models\TrackTechApp;
use Illuminate\Http\Request;

class TrackTechAppController extends Controller
{
    public function index(Request $request)
    {
        $query = TrackTechApp::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('app_name', 'like', "%{$search}%")
                  ->orWhere('package_name', 'like', "%{$search}%")
                  ->orWhere('live_version', 'like', "%{$search}%")
                  ->orWhere('test_version', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 25);
        $apps = $query->orderBy('sno', 'asc')->paginate($perPage)->withQueryString();

        return view('app_test.index', compact('apps', 'perPage'));
    }
}
