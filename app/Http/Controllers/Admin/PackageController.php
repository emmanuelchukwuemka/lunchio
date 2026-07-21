<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order')->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function toggleActive(Package $package)
    {
        $package->update(['active' => ! $package->active]);

        return back()->with('status', 'Package status updated.');
    }
}
