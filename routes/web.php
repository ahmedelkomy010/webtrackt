<?php

use App\Http\Controllers\Admin\AboutSettingsController;
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
use App\Http\Controllers\Admin\ContactSettingsController;
use App\Http\Controllers\Admin\RobotsTxtController as AdminRobotsTxtController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\TickerSettingsController;
use App\Http\Controllers\PrivacyPageController;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\RobotsTxtController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\SitemapController;
use App\Support\Locale;
use App\Support\SiteUrl;
use Illuminate\Support\Facades\Route;

foreach (Locale::PREFIX as $localeCode => $localePrefix) {
    foreach (SiteUrl::COUNTRIES as $countryCode) {
        $prefix = SiteUrl::buildPrefix($localeCode, $countryCode);
        $middleware = 'locale:'.$localeCode.','.$countryCode;
        $isDefault = $localeCode === Locale::AR && $countryCode === SiteUrl::DEFAULT_COUNTRY;

        $register = function () use ($isDefault) {
            Route::get('/', HomeController::class);

            if ($isDefault) {
                Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
                Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
                Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
                Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');
                Route::get('/about', AboutPageController::class)->name('about');
                Route::get('/contact', ContactPageController::class)->name('contact');
                Route::get('/privacy', PrivacyPageController::class)->name('privacy');
            } else {
                Route::get('/blog', [BlogController::class, 'index']);
                Route::get('/blog/{slug}', [BlogController::class, 'show']);
                Route::get('/services', [ServicePageController::class, 'index']);
                Route::get('/services/{slug}', [ServicePageController::class, 'show']);
                Route::get('/about', AboutPageController::class);
                Route::get('/contact', ContactPageController::class);
                Route::get('/privacy', PrivacyPageController::class);
            }
        };

        if ($prefix === '') {
            Route::middleware($middleware)->group($register);
        } else {
            Route::prefix($prefix)->middleware($middleware)->group($register);
        }
    }
}

Route::get('/api/content', [ContentController::class, 'index']);
Route::post('/api/contact', [App\Http\Controllers\ContactController::class, 'store']);
Route::post('/api/reviews', [App\Http\Controllers\ReviewController::class, 'store']);

Route::get('/sitemap.xml', SitemapController::class);
Route::get('/robots.txt', RobotsTxtController::class);

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
        Route::get('robots-txt', [AdminRobotsTxtController::class, 'edit'])->name('robots.edit');
        Route::put('robots-txt', [AdminRobotsTxtController::class, 'update'])->name('robots.update');
        Route::delete('robots-txt', [AdminRobotsTxtController::class, 'destroy'])->name('robots.destroy');
        Route::get('ticker', [TickerSettingsController::class, 'edit'])->name('ticker.edit');
        Route::put('ticker', [TickerSettingsController::class, 'update'])->name('ticker.update');
        Route::get('pages', [PageContentController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}', [PageContentController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [PageContentController::class, 'update'])->name('pages.update');
        Route::get('contact-settings', [ContactSettingsController::class, 'edit'])->name('contact.edit');
        Route::put('contact-settings', [ContactSettingsController::class, 'update'])->name('contact.update');
        Route::get('about-settings', [AboutSettingsController::class, 'edit'])->name('about.edit');
        Route::put('about-settings', [AboutSettingsController::class, 'update'])->name('about.update');
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
