<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliverableController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('view-assets'), 403);

        $deliverables = $this->sentDeliverables();

        $categories = [
            'Logos' => $deliverables->where('type', Deliverable::TYPE_LOGO),
            'Brand Kit' => $deliverables->where('type', Deliverable::TYPE_BRAND_PDF),
            'Documents' => $deliverables->where('type', Deliverable::TYPE_CAC_DOC),
            'Flyers' => $deliverables->whereIn('type', [Deliverable::TYPE_OTHER, Deliverable::TYPE_LANDING_PAGE, Deliverable::TYPE_SOCIAL_MEDIA]),
        ];

        return view('customer.deliverables.index', compact('categories'));
    }

    public function brandAssets()
    {
        abort_unless(Auth::user()->canAccess('view-assets'), 403);

        $deliverables = $this->sentDeliverables();

        $categories = [
            'Logo' => $deliverables->where('type', Deliverable::TYPE_LOGO),
            'Brand Kit' => $deliverables->where('type', Deliverable::TYPE_BRAND_PDF),
            'Business Card' => $deliverables->where('type', Deliverable::TYPE_BUSINESS_CARD),
            'Letterhead' => $deliverables->filter(fn ($d) => str_contains(strtolower($d->title), 'letterhead')),
        ];

        return view('customer.deliverables.brand-assets', compact('categories'));
    }

    public function businessDocuments()
    {
        abort_unless(Auth::user()->canAccess('view-assets'), 403);

        $deliverables = $this->sentDeliverables();

        $categories = [
            'Business Profile' => $deliverables->where('type', Deliverable::TYPE_BUSINESS_PROFILE),
            'Registration Documents' => $deliverables->where('type', Deliverable::TYPE_CAC_DOC),
            'Company Documents' => $deliverables->filter(fn ($d) => str_contains(strtolower($d->title), 'company')),
            'Certificates' => $deliverables->filter(fn ($d) => str_contains(strtolower($d->title), 'certificate')),
        ];

        return view('customer.deliverables.business-documents', compact('categories'));
    }

    public function marketingAssets()
    {
        abort_unless(Auth::user()->canAccess('manage-calendar'), 403);

        $deliverables = $this->sentDeliverables();

        $categories = [
            'Social Media' => $deliverables->where('type', Deliverable::TYPE_SOCIAL_MEDIA),
            'Content Plan' => $deliverables->where('type', Deliverable::TYPE_CONTENT_PLAN),
            'Advertisements' => $deliverables->filter(fn ($d) => str_contains(strtolower($d->title), 'ad')),
        ];

        return view('customer.deliverables.marketing-assets', compact('categories'));
    }

    /**
     * Deliverables the admin has actually sent to the founder for review.
     * Uploads still sitting in draft are not visible here.
     */
    private function sentDeliverables()
    {
        $businessOwnerId = Auth::user()->businessOwner()->id;

        return Deliverable::whereHas('order', function ($query) use ($businessOwnerId) {
            $query->where('user_id', $businessOwnerId);
        })->where('is_current', true)->whereNotNull('sent_at')->with('order.package')->latest()->get();
    }

    public function requestRevision(Request $request, Deliverable $deliverable)
    {
        abort_unless(Auth::user()->canAccess('view-assets'), 403);

        // Ensure user's business owns this deliverable's order
        if ($deliverable->order->user_id !== Auth::user()->businessOwner()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'revision_notes' => ['required', 'string', 'max:2000'],
        ]);

        // In a real application, you might create a separate Revision model
        // or just add a revision_requested flag to the Deliverable.
        // We'll add the revision notes to the Deliverable's notes for now,
        // and transition the Order status to 'in_progress' or 'in_review'.

        $deliverable->update([
            'notes' => $validated['revision_notes'],
            'approved_at' => null,
        ]);

        // Add note to AdminNotes so staff sees it
        $deliverable->order->adminNotes()->create([
            'staff_id' => Auth::id(), // We're using staff_id but it's from the client, a bit hacky but works for MVP
            'note' => "Client requested revision on '{$deliverable->title}': \n" . $validated['revision_notes'],
        ]);

        return back()->with('status', 'Revision requested successfully! Our team will get back to you shortly.');
    }

    public function approve(Deliverable $deliverable)
    {
        abort_unless(Auth::user()->canAccess('view-assets'), 403);
        abort_unless($deliverable->order->user_id === Auth::user()->businessOwner()->id, 403);

        $deliverable->update(['approved_at' => now()]);

        return back()->with('status', "'{$deliverable->title}' approved.");
    }
}
