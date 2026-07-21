<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use App\Models\Order;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public const CATEGORY_MAP = [
        'Website' => [Deliverable::TYPE_LANDING_PAGE],
        'Branding' => [Deliverable::TYPE_LOGO, Deliverable::TYPE_BRAND_PDF],
        'Registration' => [Deliverable::TYPE_CAC_DOC],
        'Marketing' => [Deliverable::TYPE_OTHER],
    ];

    public function index(Request $request)
    {
        $category = $request->query('category');

        $orders = Order::with(['user', 'package', 'deliverables', 'assignedStaff'])
            ->latest()
            ->get();

        $categories = $category ? [$category => self::CATEGORY_MAP[$category] ?? []] : self::CATEGORY_MAP;

        $projects = [];

        foreach ($orders as $order) {
            foreach ($categories as $categoryName => $types) {
                $deliverables = $order->deliverables->whereIn('type', $types)->where('is_current', true);

                $projects[] = [
                    'order' => $order,
                    'category' => $categoryName,
                    'deliverables' => $deliverables,
                    'status' => $deliverables->isNotEmpty() ? 'delivered' : $order->status,
                ];
            }
        }

        return view('admin.projects.index', compact('projects', 'category'));
    }
}
