<?php

namespace Nishadil\Artisanpro;

use Illuminate\Support\ServiceProvider;
use Nishadil\Artisanpro\Commands\MakeTrait;
use Nishadil\Artisanpro\Commands\MakeBlade;

class ArtisanproProvider extends ServiceProvider{


    /**
    * Register Artisanpro services.
    *
    * @return void
    */
    public function register(){
        $this->commands([
            MakeTrait::class,
            MakeBlade::class
        ]);
    }



    /**
    * Bootstrap Artisanpro services.
    *
    * @return void
    */
    public function boot(){
        $this->publishes([
            __DIR__ . '/../config/Artisanpro.php' => config_path('Artisanpro.php'),
        ], 'config');
    }
}

?>