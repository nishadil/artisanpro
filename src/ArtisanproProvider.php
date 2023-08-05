<?php

namespace Nishadil\Artisanpro;

use Illuminate\Support\ServiceProvider;
use Nishadil\Artisanpro\Commands\MakeTrait;
use Nishadil\Artisanpro\Commands\MakeBlade;
use Nishadil\Artisanpro\Commands\MakeView;

class ArtisanproProvider extends ServiceProvider{


    /**
    * Register Artisanpro services.
    *
    * @return void
    */
    public function register(){
        $this->commands([
            MakeTrait::class,
            MakeBlade::class,
            MakeView::class
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