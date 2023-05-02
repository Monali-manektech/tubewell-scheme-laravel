<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateTrait extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create the trait';

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected $type = 'Trait';

    protected function getStub(){
        return base_path('stubs/trait.stub');
    }

    protected function getDefaultNamespace($rootNamespace){
        return $rootNamespace . '\Traits';
    }

    protected function replaceClass($stub, $name){
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{trait_name}}', $class, $stub);
    }
}
