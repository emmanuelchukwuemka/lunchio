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
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Founders
    Route::get('/founders', [\App\Http\Controllers\Admin\FounderController::class, 'index'])->name('founders.index');
    Route::get('/businesses', [\App\Http\Controllers\Admin\FounderController::class, 'businesses'])->name('founders.businesses');
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.status.update');
    Route::post('/leads/{lead}/notes', [LeadController::class, 'storeNote'])->name('leads.notes.store');

    // Delivery
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::patch('/orders/{order}/assign', [OrderController::class, 'assignStaff'])->name('orders.assign');
    Route::post('/orders/{order}/deliverables', [OrderController::class, 'uploadDeliverable'])->name('orders.deliverables.store');
    Route::delete('/orders/{order}/deliverables/{deliverable}', [OrderController::class, 'destroyDeliverable'])->name('orders.deliverables.destroy');
    Route::post('/orders/{order}/notes', [\App\Http\Controllers\Admin\AdminNoteController::class, 'store'])->name('orders.notes.store');
    Route::post('/orders/{order}/messages', [\App\Http\Controllers\OrderMessageController::class, 'store'])->name('orders.messages.store');
    Route::post('/orders/{order}/website', [OrderController::class, 'manageWebsite'])->name('orders.website.manage');
    Route::post('/orders/{order}/send-to-founder', [OrderController::class, 'sendToFounder'])->name('orders.send-to-founder');

    Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index');
    Route::get('/services', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('services.index');
    Route::get('/deliverables', [DeliverableController::class, 'index'])->name('deliverables.index');
    Route::get('/websites', [\App\Http\Controllers\Admin\WebsiteController::class, 'index'])->name('websites.index');
    Route::get('/websites/{website}', [\App\Http\Controllers\Admin\WebsiteController::class, 'show'])->name('websites.show');
    Route::patch('/websites/{website}', [\App\Http\Controllers\Admin\WebsiteController::class, 'update'])->name('websites.update');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status.update');

    // Finance
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::patch('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::get('/invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/payouts', [\App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('payouts.index');

    // Team
    Route::get('/staff', [UserController::class, 'staff'])->name('staff.index');
    Route::get('/assignments', [\App\Http\Controllers\Admin\AssignmentController::class, 'index'])->name('assignments.index');
    Route::patch('/assignments/{order}', [\App\Http\Controllers\Admin\AssignmentController::class, 'update'])->name('assignments.update');

    // CRM
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');

    // Content
    Route::resource('blog', BlogController::class);
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::patch('/packages/{package}/toggle', [PackageController::class, 'toggleActive'])->name('packages.toggle');

    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

    Route::get('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [\App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('testimonials.update');
    Route::patch('/testimonials/{testimonial}/toggle', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleActive'])->name('testimonials.toggle');
    Route::delete('/testimonials/{testimonial}', [\App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');

    // Admin Exclusives
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role.update');

        Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
        Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit.index');
    });
});
