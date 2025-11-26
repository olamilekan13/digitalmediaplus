<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Site Settings
    Route::resource('site-settings', App\Http\Controllers\Admin\SiteSettingController::class);
    Route::resource('hero-sections', App\Http\Controllers\Admin\HeroSectionController::class);

    // Content Management
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('about-sections', App\Http\Controllers\Admin\AboutSectionController::class);
    Route::resource('feature-highlights', App\Http\Controllers\Admin\FeatureHighlightController::class);
    Route::resource('statistics', App\Http\Controllers\Admin\StatisticController::class);
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);

    // Contact Management
    Route::resource('contact-channels', App\Http\Controllers\Admin\ContactChannelController::class);
    Route::resource('contact-messages', App\Http\Controllers\Admin\ContactMessageController::class);
});

require __DIR__.'/auth.php';
