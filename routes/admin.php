<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliverableController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AuditController;

Route::middleware(['auth', 'role:admin|staff'])->prefix('admin')->name('admin.')->group(function () {
    
    // Command Center Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Delivery
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::patch('/orders/{order}/assign', [OrderController::class, 'assignStaff'])->name('orders.assign');
    Route::post('/orders/{order}/deliverables', [OrderController::class, 'uploadDeliverable'])->name('orders.deliverables.store');
    Route::post('/orders/{order}/notes', [\App\Http\Controllers\Admin\AdminNoteController::class, 'store'])->name('orders.notes.store');
    
    Route::get('/deliverables', [DeliverableController::class, 'index'])->name('deliverables.index');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    
    // Finance
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    // CRM
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');

    // Content
    Route::resource('blog', BlogController::class);
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');

    // Admin Exclusives
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role.update');
        
        Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit.index');
    });
});
