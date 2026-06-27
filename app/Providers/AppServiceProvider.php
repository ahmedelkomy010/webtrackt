<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole() && ! $this->app->runningUnitTests()) {
            return;
        }

        try {
            $request = request();
            $root = $request->getSchemeAndHttpHost();

            $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

            if (str_ends_with($scriptName, '/public/index.php')) {
                $root .= substr($scriptName, 0, -strlen('/public/index.php'));
            } elseif (str_ends_with($scriptName, '/index.php') && $scriptName !== '/index.php') {
                $root .= substr($scriptName, 0, -strlen('/index.php'));
            }

            URL::forceRootUrl($root);
        } catch (\Throwable) {
            //
        }
    }
}
