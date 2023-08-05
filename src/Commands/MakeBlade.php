<?php

namespace Nishadil\Artisanpro\Commands;


use Nishadil\Artisanpro\Support\FileGenerator;
use Nishadil\Artisanpro\Support\GenerateFile;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

use Exception;

class MakeBlade extends CommandGenerator{

    /**
    * argumentName
    *
    * @var string
    */
    public $argumentName = 'view';


    /**
    * Name and signature of Command.
    * name
    * @var string
    */
    protected $name = 'make:view';


    /**
    * command description.
    * description
    * @var string
    */
    protected $description = 'Command description';


    /**
    * __construct
    *
    * @return void
    */
    public function __construct(){
        parent::__construct();
    }


    /**
    * Get Command argument EX : HasAuth
    * getArguments
    *
    * @return array
    */
    protected function getArguments(): array{
        return [
            ['view', InputArgument::REQUIRED, 'The name of the view'],
        ];
    }


    /**
    * getViewName
    *
    * @return string
    */
    private function getViewName() :string {
        $view = Str::camel($this->argument('view'));
        if( Str::contains( strtolower( $view ), '.blade.php' ) === false ):
            $view .= '.blade.php';
        endif;
        return $view;
    }


    /**
    * getDestinationFilePath
    *
    * @return string
    */
    protected function getDestinationFilePath() :string {
        return app_path()."/resources/views".'/'. $this->getViewName();
    }


    /**
    * getTemplateFilePath
    *
    * @return string
    */
    protected function getTemplateFilePath() :string {
        return '/templates/blade.stub';
    }


    /**
    * getTemplateContents
    *
    * @return string
    */
    protected function getTemplateContents() :string {
        return ( 
            new GenerateFile( 
                __DIR__.$this->getTemplateFilePath()
            )
        )->render();
    }


    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle(){
        $path = str_replace( '\\', '/', $this->getDestinationFilePath() );

        if( !$this->laravel['files']->isDirectory( $dir = dirname($path) ) ):
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        endif;

        $contents = $this->getTemplateContents();

        try{
            (
                new FileGenerator( $path, $contents )
            )->generate();
            $this->info("Created : {$path}");
        }catch(Exception $e){
            $this->error("File : {$e->getMessage()}");
            return E_ERROR;
        }
    return 0;
    }

}
?>