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
    Route::get('/websites/{website}', [\App\Http\Controllers\Customer\WebsiteController::class, 'show'])->name('websites.show');
    Route::get('/checkout/{order}', [PaymentController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{order}', [PaymentController::class, 'process'])->name('checkout.process');

    Route::post('/deliverables/{deliverable}/revision', [\App\Http\Controllers\Customer\DeliverableController::class, 'requestRevision'])->name('deliverables.revision');

    // Management Dashboard Placeholders
    Route::get('/launches', [OrderController::class, 'index'])->name('customer.launches.index');
    Route::get('/assets', [\App\Http\Controllers\Customer\DeliverableController::class, 'index'])->name('customer.assets.index');
    Route::get('/billing', [\App\Http\Controllers\Customer\InvoiceController::class, 'index'])->name('customer.billing.index');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Customer\InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('/calendar', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'store'])->name('calendar.store');
    Route::post('/calendar/ai-generate', [\App\Http\Controllers\Customer\ContentCalendarController::class, 'aiGenerate'])->name('calendar.ai-generate');

    Route::get('/copilot', [\App\Http\Controllers\Customer\CopilotController::class, 'index'])->name('copilot.index');
    Route::post('/copilot/chat', [\App\Http\Controllers\Customer\CopilotController::class, 'chat'])->name('copilot.chat');
});
