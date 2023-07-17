<?php

namespace App\Providers;

use App\Http\Controllers\ClientOrderController;
use App\Repository\ClientOrderRepo;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\CrudRepoInterfaceInterface;

class CrudRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ClientOrderController::class)
            ->needs(CrudRepoInterfaceInterface::class)
            ->give(function () {
                return new ClientOrderRepo();
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
