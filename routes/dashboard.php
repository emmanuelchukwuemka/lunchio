<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/intake', \App\Livewire\IntakeWizard::class)->name('intake');
    Route::get('/website-builder', \App\Livewire\WebsiteBuilderWizard::class)->name('website-builder');
    Route::get('/website', [\App\Http\Controllers\Customer\WebsiteController::class, 'index'])->name('websites.index');
    Route::get('/websites/{website}', [\App\Http\Controllers\Customer\WebsiteController::class, 'show'])->name('websites.show');
    Route::post('/websites/{website}/approve', [\App\Http\Controllers\Customer\WebsiteController::class, 'approve'])->name('websites.approve');
    Route::get('/checkout/{order}', [PaymentController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{order}', [PaymentController::class, 'process'])->name('checkout.process');

    Route::get('/business', [\App\Http\Controllers\Customer\BusinessController::class, 'index'])->name('business.index');
    Route::get('/my-package', [\App\Http\Controllers\Customer\PackageController::class, 'index'])->name('customer.package.index');
    Route::get('/projects', [\App\Http\Controllers\Customer\ProjectController::class, 'index'])->name('projects.index');
    Route::get('/messages', [\App\Http\Controllers\Customer\MessageController::class, 'index'])->name('messages.index');

    Route::post('/deliverables/{deliverable}/revision', [\App\Http\Controllers\Customer\DeliverableController::class, 'requestRevision'])->name('deliverables.revision');
    Route::post('/deliverables/{deliverable}/approve', [\App\Http\Controllers\Customer\DeliverableController::class, 'approve'])->name('deliverables.approve');

    Route::post('/orders/{order}/messages', [\App\Http\Controllers\OrderMessageController::class, 'store'])->name('orders.messages.store');

    // Management Dashboard Placeholders
    Route::get('/launches', [OrderController::class, 'index'])->name('customer.launches.index');
    Route::get('/assets', [\App\Http\Controllers\Customer\DeliverableController::class, 'index'])->name('customer.assets.index');
    Route::get('/brand-assets', [\App\Http\Controllers\Customer\DeliverableController::class, 'brandAssets'])->name('customer.brand-assets.index');
    Route::get('/business-documents', [\App\Http\Controllers\Customer\DeliverableController::class, 'businessDocuments'])->name('customer.business-documents.index');
    Route::get('/marketing', [\App\Http\Controllers\Customer\DeliverableController::class, 'marketingAssets'])->name('marketing.index');

    Route::get('/campaigns', [\App\Http\Controllers\Customer\CampaignController::class, 'index'])->name('campaigns.index');
    Route::post('/campaigns', [\App\Http\Controllers\Customer\CampaignController::class, 'store'])->name('campaigns.store');
    Route::put('/campaigns/{campaign}', [\App\Http\Controllers\Customer\CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [\App\Http\Controllers\Customer\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/billing', [\App\Http\Controllers\Customer\InvoiceController::class, 'index'])->name('customer.billing.index');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Customer\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/subscription', [\App\Http\Controllers\Customer\InvoiceController::class, 'subscriptions'])->name('customer.subscription.index');
    Route::get('/upgrade', [\App\Http\Controllers\Customer\PackageController::class, 'upgrade'])->name('package.upgrade');
    Route::post('/upgrade/{package}', [\App\Http\Controllers\Customer\PackageController::class, 'requestUpgrade'])->name('package.upgrade.request');

    Route::get('/calendar', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'store'])->name('calendar.store');
    Route::post('/calendar/ai-generate', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'aiGenerate'])->name('calendar.ai-generate');

    Route::get('/copilot', [\App\Http\Controllers\Customer\CopilotController::class, 'index'])->name('copilot.index');
    Route::post('/copilot/chat', [\App\Http\Controllers\Customer\CopilotController::class, 'chat'])->name('copilot.chat');

    Route::get('/team', [\App\Http\Controllers\Customer\TeamController::class, 'index'])->name('team.index');
    Route::post('/team', [\App\Http\Controllers\Customer\TeamController::class, 'store'])->name('team.store');
    Route::patch('/team/{member}/permissions', [\App\Http\Controllers\Customer\TeamController::class, 'updatePermissions'])->name('team.permissions.update');
    Route::delete('/team/{member}', [\App\Http\Controllers\Customer\TeamController::class, 'destroy'])->name('team.destroy');

    Route::get('/crm', [\App\Http\Controllers\Customer\ContactController::class, 'index'])->name('crm.index');
    Route::get('/crm/follow-ups', [\App\Http\Controllers\Customer\ContactController::class, 'followUps'])->name('crm.follow-ups');
    Route::post('/crm', [\App\Http\Controllers\Customer\ContactController::class, 'store'])->name('crm.store');
    Route::put('/crm/{contact}', [\App\Http\Controllers\Customer\ContactController::class, 'update'])->name('crm.update');
    Route::delete('/crm/{contact}', [\App\Http\Controllers\Customer\ContactController::class, 'destroy'])->name('crm.destroy');
    Route::post('/crm/{contact}/follow-ups', [\App\Http\Controllers\Customer\ContactController::class, 'storeFollowUp'])->name('crm.follow-ups.store');

    Route::get('/experts', [\App\Http\Controllers\Customer\ExpertController::class, 'index'])->name('experts.index');
    Route::post('/experts/{expert}/book', [\App\Http\Controllers\Customer\ExpertController::class, 'store'])->name('experts.book');

    Route::get('/sales-analytics', [\App\Http\Controllers\Customer\AnalyticsController::class, 'index'])->name('customer.analytics.index');

    Route::view('/payment-setup', 'customer.payment-setup.index')->name('payment-setup.index');
});
