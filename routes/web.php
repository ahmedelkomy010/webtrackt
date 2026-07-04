<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NavLinkController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\WhyUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'app');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');

Route::get('/api/content', [ContentController::class, 'index']);
Route::post('/api/contact', [App\Http\Controllers\ContactController::class, 'store']);
Route::post('/api/reviews', [App\Http\Controllers\ReviewController::class, 'store']);

Route::get('/sitemap.xml', SitemapController::class);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('stats', StatController::class)->except(['show']);
        Route::resource('why-us', WhyUsController::class)->except(['show'])->parameters(['why-us' => 'why_u']);
        Route::resource('nav-links', NavLinkController::class)->except(['show'])->parameters(['nav-links' => 'nav_link']);
        Route::resource('posts', PostController::class)->except(['show']);
        Route::post('posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
        Route::get('seo', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [SeoController::class, 'update'])->name('seo.update');
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('profile', [UserController::class, 'profile'])->name('profile.edit');
        Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::resource('reviews', ReviewController::class)->except(['show']);
        Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    });
});
