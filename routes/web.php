<?php

use App\Http\Controllers\Marketing\BlogController;
use App\Http\Controllers\Marketing\ContactController;
use App\Http\Controllers\Marketing\FaqController;
use App\Http\Controllers\Marketing\GetStartedController;
use App\Http\Controllers\Marketing\PackageController;
use App\Http\Controllers\Marketing\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/legal/{type}', [PageController::class, 'legal'])->name('legal');

Route::get('/get-started', function (\Illuminate\Http\Request $request) {
    return redirect()->route('register', $request->query());
})->name('get-started');

Route::get('/ai-onboarding', [\App\Http\Controllers\Marketing\AiOnboardingController::class, 'create'])->name('ai-onboarding');
Route::post('/ai-onboarding/chat', [\App\Http\Controllers\Marketing\AiOnboardingController::class, 'chat'])->name('ai-onboarding.chat');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blog/{blogPost:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/dashboard.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
