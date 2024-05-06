<?php

namespace App\Providers;

use Illuminate\Cache\FileStore;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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
        Cache::macro('getTTL', function (string $key): ?int {
            $fs = new class extends FileStore {
                public function __construct()
                {
                    parent::__construct(App::get('files'), config('cache.stores.file.path'));
                }
        
                public function getTTL(string $key): ?int
                {
                    return $this->getPayload($key)['time'] ?? null;
                }
            };
        
            return $fs->getTTL($key);
        });
    }
}
