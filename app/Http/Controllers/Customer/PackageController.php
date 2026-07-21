<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Notifications\NewOrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businessOwner();

        $orders = $business->orders()->with(['package.features'])->latest()->get();

        $currentPackage = $orders->first()?->package;

        $allPackages = Package::where('active', true)->with('features')->orderBy('sort_order')->get();

        return view('customer.package.index', compact('orders', 'currentPackage', 'allPackages'));
    }

    public function upgrade()
    {
        $business = Auth::user()->businessOwner();

        $currentPackage = $business->orders()->latest()->first()?->package;

        $allPackages = Package::where('active', true)->orderBy('sort_order')->get();

        return view('customer.package.upgrade', compact('currentPackage', 'allPackages'));
    }

    public function requestUpgrade(Request $request, Package $package)
    {
        $business = Auth::user()->businessOwner();

        $latestOrder = $business->orders()->latest()->first();

        if ($latestOrder) {
            $message = $latestOrder->messages()->create([
                'user_id' => Auth::id(),
                'body' => "I'd like to upgrade to the {$package->name} package.",
            ]);

            $recipient = $latestOrder->assignedStaff ?? User::role('admin')->first();
            $recipient?->notify(new NewOrderMessage($message->load('user')));
        }

        return back()->with('status', "Upgrade request for {$package->name} sent to your Launchio team.");
    }
}
