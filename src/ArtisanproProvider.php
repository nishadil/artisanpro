<?php

namespace Nishadil\Artisanpro;

use Illuminate\Support\ServiceProvider;
use Nishadil\Artisanpro\Commands\MakeTraitCommand;

class ArtisanproProvider extends ServiceProvider{


    /**
    * Register Artisanpro services.
    *
    * @return void
    */
    public function register(){
        $this->commands([
            MakeTraitCommand::class
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