<?php

namespace App\Providers;

use App\Repository\Interfaces\CrudRepoInterface;
use App\Repository\PostRepo;
use Illuminate\Support\ServiceProvider;

class RepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CrudRepoInterface::class, PostRepo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
