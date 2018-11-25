<?php

namespace Motor\CMS\Console\Commands;

use Motor\Core\Console\Commands\MotorMakeServiceCommand;

class MotorMakeComponentClassCommand extends MotorMakeServiceCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motor:make:component-class';

    protected $signature = 'motor:make:component-class {name} {--path=} {--namespace=} {--model=} {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component class';

    protected $type = 'Component class';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Components';
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/component_class.stub';
    }

}