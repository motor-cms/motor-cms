<?php

namespace Motor\CMS\Console\Commands;

use Motor\Core\Console\Commands\MotorMakeServiceCommand;

/**
 * Class MotorMakeComponentClassCommand
 */
class MotorMakeComponentClassCommand extends MotorMakeServiceCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motor:make:component-class';

    protected $signature = 'motor:make:component-class {name} {--path=} {--namespace=} {--model=} {--parent=} {--stub_path=}';

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
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Components';
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        if ($this->option('stub_path')) {
            return $this->option('stub_path');
        }

        return __DIR__.'/stubs/component_class.stub';
    }
}
