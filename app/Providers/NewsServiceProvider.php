<?php

namespace App\Providers;

use App\Interfaces\NewsProviderInterface;
use App\Services\News\NewsService;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(NewsProviderInterface::class, function () {
            return new NewsService();
        });

    }
}


