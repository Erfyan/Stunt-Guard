<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production' || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Blade::directive('vite', function ($expression) {
            preg_match_all('/[\'\"]([^\'\"]+)[\'\"]/', $expression, $matches);
            $paths = $matches[1] ?? [];

            $html = [];
            $manifestPath = public_path('build/manifest.json');
            $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];

            foreach ($paths as $path) {
                $path = str_replace(['\\', '/'], '/', $path);

                if (isset($manifest[$path]['file'])) {
                    $assetPath = '/build/' . $manifest[$path]['file'];
                    if (str_contains($path, '.css')) {
                        $html[] = '<link rel="stylesheet" href="' . $assetPath . '" />';
                    } else {
                        $html[] = '<script type="module" src="' . $assetPath . '"></script>';
                    }
                } else {
                    if (str_contains($path, '.css')) {
                        $html[] = '<link rel="stylesheet" href="/build/' . basename($path) . '" />';
                    } else {
                        $html[] = '<script type="module" src="/build/' . basename($path) . '"></script>';
                    }
                }
            }

            return implode("\n", $html);
        });
    }
}
