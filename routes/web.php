<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Distributor Application Form (Public Route)
Route::get('/become-distributor', function () {
    return view('pages.become-distributor');
})->name('become-distributor');

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

    // Distributor Applications Management
    Route::get('distributor-applications', function () {
        return view('admin.distributor-applications.index');
    })->name('distributor-applications.index');

    // Custom Pages
    Route::resource('custom-pages', App\Http\Controllers\Admin\CustomPageController::class)->except(['show', 'store', 'update', 'destroy']);
    Route::post('upload-image', [App\Http\Controllers\Admin\CustomPageController::class, 'uploadImage'])->name('upload-image');

    // Admin Management (Super Admin only)
    Route::middleware('role:super-admin')->group(function () {
        Route::resource('admin-users', App\Http\Controllers\Admin\AdminUserController::class);
    });
});

// Auth routes must be loaded before the catch-all slug route
require __DIR__.'/auth.php';

// Custom Pages (must be last to avoid conflicting with other routes)
Route::get('/{slug}', [App\Http\Controllers\CustomPageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('page.show');
