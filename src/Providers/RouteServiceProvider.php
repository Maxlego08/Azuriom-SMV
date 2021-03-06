<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Providers;

use Azuriom\Extensions\Plugin\BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::prefix('admin/serveur/minecraft/vote')
            ->middleware('admin-access')
            ->name($this->plugin->id.'.admin.')
            ->group(plugin_path($this->plugin->id.'/routes/admin.php'));

        Route::prefix('api/serveur/minecraft/vote')
            ->middleware('api')
            ->name($this->plugin->id.'.api.')
            ->group(plugin_path($this->plugin->id.'/routes/api.php'));
    }
}
