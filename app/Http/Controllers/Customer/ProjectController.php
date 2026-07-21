<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Maps project categories shown to the founder to the underlying
     * Deliverable types that fulfil them. "Website" is handled separately
     * since it's tracked on the Website model, not as a Deliverable.
     */
    public const CATEGORY_MAP = [
        'Website' => [],
        'Branding' => [Deliverable::TYPE_LOGO, Deliverable::TYPE_BRAND_PDF, Deliverable::TYPE_BUSINESS_CARD],
        'Registration' => [Deliverable::TYPE_CAC_DOC],
        'Marketing' => [Deliverable::TYPE_OTHER, Deliverable::TYPE_SOCIAL_MEDIA, Deliverable::TYPE_CONTENT_PLAN],
    ];

    /**
     * Buckets the underlying order/delivery statuses into the three
     * high-level tabs shown to the founder.
     */
    public const STATUS_BUCKETS = [
        'active' => ['submitted', 'in_progress'],
        'pending_review' => ['in_review', 'approved'],
        'completed' => ['delivered'],
    ];

    public function index(Request $request)
    {
        abort_unless(Auth::user()->canAccess('manage-orders'), 403);

        $bucket = $request->query('bucket');

        $business = Auth::user()->businessOwner();

        $orders = $business->orders()->with(['package', 'deliverables', 'website'])->latest()->get();

        $projects = [];

        foreach ($orders as $order) {
            foreach (self::CATEGORY_MAP as $category => $types) {
                if ($category === 'Website') {
                    $deliverables = collect();
                    $status = $order->website?->sent_at ? 'delivered' : $order->status;
                } else {
                    $deliverables = $order->deliverables
                        ->whereIn('type', $types)
                        ->where('is_current', true)
                        ->whereNotNull('sent_at');
                    $status = $deliverables->isNotEmpty() ? 'delivered' : $order->status;
                }

                if ($bucket && ! in_array($status, self::STATUS_BUCKETS[$bucket] ?? [], true)) {
                    continue;
                }

                $projects[] = [
                    'order' => $order,
                    'category' => $category,
                    'deliverables' => $deliverables,
                    'website' => $category === 'Website' ? $order->website : null,
                    'status' => $status,
                ];
            }
        }

        return view('customer.projects.index', compact('projects', 'bucket'));
    }
}
