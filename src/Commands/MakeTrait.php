<?php

namespace Nishadil\Artisanpro\Commands;


use Nishadil\Artisanpro\Support\FileGenerator;
use Nishadil\Artisanpro\Support\GenerateFile;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

use Exception;

class MakeTrait extends CommandGenerator{

    /**
    * argumentName
    *
    * @var string
    */
    public $argumentName = 'trait';


    /**
    * Name and signature of Command.
    * name
    * @var string
    */
    protected $name = 'make:trait';


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
            ['trait', InputArgument::REQUIRED, 'The name of the trait'],
        ];
    }


    /**
    * getTraitName
    *
    * @return string
    */
    private function getTraitName() :string {
        return Str::studly($this->argument('trait'));
    }


    /**
    * getDestinationFilePath
    *
    * @return string
    */
    protected function getDestinationFilePath() :string {
        return app_path()."/Traits".'/'. $this->getTraitName() . '.php';
    }

    /**
    * getTraitNameWithoutNamespace
    *
    * @return string
    */
    private function getTraitNameWithoutNamespace() :string {
        return class_basename($this->getTraitName());
    }

    /**
    * getDefaultNamespace
    *
    * @return string
    */
    public function getDefaultNamespace() :string {
        return "App\\Traits";
    }

    /**
    * getTemplateFilePath
    *
    * @return string
    */
    protected function getTemplateFilePath() :string {
        return '/templates/traits.stub';
    }

    /**
    * getTemplateContents
    *
    * @return string
    */
    protected function getTemplateContents() :string {
        return( 
            new GenerateFile(
                __DIR__.$this->getTemplateFilePath(),
                [
                    'CLASS_NAMESPACE'   => $this->getClassNamespace(),
                    'CLASS'             => $this->getTraitNameWithoutNamespace()
                ]
            )
        )->render();
    }

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle(){
        $path = str_replace('\\', '/', $this->getDestinationFilePath());

        if( !$this->laravel['files']->isDirectory( $dir = dirname( $path ) ) ):
            $this->laravel['files']->makeDirectory( $dir, 0777, true );
        endif;

        $contents = $this->getTemplateContents();

        try{
            (new FileGenerator( $path, $contents ))->generate();
            $this->info("Created : {$path}");
        }catch(Exception $e){
            $this->error("File : {$e->getMessage()}");
            return E_ERROR;
        }
    return 0;
    }

}
?>