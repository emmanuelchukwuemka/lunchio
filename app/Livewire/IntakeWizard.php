<?php

namespace App\Livewire;

use App\Models\IntakeDraft;
use App\Models\Package;
use App\Services\OrderStatusService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class IntakeWizard extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    public int $totalSteps = 4;

    public ?IntakeDraft $draft = null;

    public array $data = [
        'package_id' => null,
        'business_name' => '',
        'business_description' => '',
        'industry' => '',
        'business_stage' => '',
        'target_audience' => '',
        'location' => '',
        'has_logo' => false,
        'has_website' => false,
        'existing_assets_notes' => '',
    ];

    public $existingAsset = null;

    public ?string $existingAssetPath = null;

    public function mount(): void
    {
        abort_unless(Auth::user()->canAccess('manage-orders'), 403);

        $this->draft = IntakeDraft::firstOrCreate(
            ['user_id' => Auth::user()->businessOwner()->id, 'order_id' => null],
            ['current_step' => 1, 'data' => $this->data, 'is_draft' => true]
        );

        $this->data = array_merge($this->data, $this->draft->data ?? []);
        $this->currentStep = $this->draft->current_step ?: 1;
        $this->existingAssetPath = $this->data['existing_asset_path'] ?? null;

        if (! $this->data['package_id'] && request('package')) {
            $this->data['package_id'] = (int) request('package');
        }
    }

    public function updated(string $propertyName): void
    {
        if (str_starts_with($propertyName, 'data.')) {
            $this->saveDraft();
        }
    }

    public function generateNameWithAi(): void
    {
        sleep(1); // Simulating AI thinking
        $names = ['Lumina Solutions', 'Apex Ventures', 'Nova Launch', 'Zenith Dynamics'];
        $this->data['business_name'] = $names[array_rand($names)];
        $this->saveDraft();
    }

    public function generateDescriptionWithAi(): void
    {
        sleep(1); // Simulating AI thinking
        if (empty($this->data['business_name'])) {
            $this->data['business_description'] = "We are an innovative new business focused on delivering high-quality services to our target market with speed and precision.";
        } else {
            $this->data['business_description'] = "{$this->data['business_name']} is an innovative startup focused on delivering premium solutions, streamlining processes, and driving massive growth for our clients.";
        }
        $this->saveDraft();
    }

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'data.package_id' => ['required', 'exists:packages,id'],
                'data.business_name' => ['required', 'string', 'max:255'],
                'data.business_description' => ['required', 'string', 'max:2000'],
            ],
            2 => [
                'data.industry' => ['required', 'string', 'max:255'],
                'data.business_stage' => ['required', 'string', 'max:255'],
            ],
            3 => [
                'data.target_audience' => ['required', 'string', 'max:1000'],
                'data.location' => ['required', 'string', 'max:255'],
            ],
            4 => [
                'data.has_logo' => ['boolean'],
                'data.has_website' => ['boolean'],
                'data.existing_assets_notes' => ['nullable', 'string', 'max:2000'],
                'existingAsset' => ['nullable', 'file', 'max:10240'],
            ],
            default => [],
        };
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->currentStep));

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }

        $this->saveDraft();
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }

        $this->saveDraft();
    }

    protected function saveDraft(): void
    {
        $payload = $this->data;
        $payload['existing_asset_path'] = $this->existingAssetPath;

        $this->draft->update([
            'current_step' => $this->currentStep,
            'data' => $payload,
        ]);
    }

    public function submit(OrderStatusService $orderStatusService)
    {
        $this->validate($this->rulesForStep(4));

        if ($this->existingAsset) {
            $this->existingAssetPath = $this->existingAsset->store('intake-assets/'.Auth::id(), 'local');
        }

        $this->saveDraft();

        $package = Package::findOrFail($this->data['package_id']);
        $order = $orderStatusService->createOrder(Auth::user()->businessOwner(), $package);

        $this->draft->update([
            'order_id' => $order->id,
            'is_draft' => false,
        ]);

        return redirect()->route('checkout.show', $order);
    }

    public function render()
    {
        return view('livewire.intake-wizard', [
            'packages' => Package::where('active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
