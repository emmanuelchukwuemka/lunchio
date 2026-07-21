<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCalendarItem;
use App\Models\Deliverable;
use App\Models\Subscription;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = [
            [
                'name' => 'Business Registration',
                'category' => 'Registration',
                'delivered_count' => Deliverable::where('type', Deliverable::TYPE_CAC_DOC)->where('is_current', true)->count(),
            ],
            [
                'name' => 'Branding',
                'category' => 'Branding',
                'delivered_count' => Deliverable::whereIn('type', [Deliverable::TYPE_LOGO, Deliverable::TYPE_BRAND_PDF])->where('is_current', true)->count(),
            ],
            [
                'name' => 'Websites',
                'category' => 'Website',
                'delivered_count' => Deliverable::where('type', Deliverable::TYPE_LANDING_PAGE)->where('is_current', true)->count(),
            ],
            [
                'name' => 'Marketing',
                'category' => 'Marketing',
                'delivered_count' => Deliverable::where('type', Deliverable::TYPE_OTHER)->where('is_current', true)->count(),
            ],
        ];

        $growthSupport = [
            'name' => 'Growth Support',
            'active_subscriptions' => Subscription::where('status', Subscription::STATUS_ACTIVE)->count(),
            'content_items' => ContentCalendarItem::count(),
        ];

        return view('admin.services.index', compact('services', 'growthSupport'));
    }
}
