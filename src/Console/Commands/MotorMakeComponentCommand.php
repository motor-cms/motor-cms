<?php

namespace Motor\CMS\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MotorMakeComponentCommand
 * @package Motor\CMS\Console\Commands
 */
class MotorMakeComponentCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'motor:make:component {name} {create_model=1} {locale=en} {--path=} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a motor cms component';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $classSingular = Str::singular('Component' . Str::studly($this->argument('name')));
        $classPlural   = Str::plural('Component' . Str::studly($this->argument('name')));
        $table         = Str::plural('component_' . Str::snake(class_basename($this->argument('name'))));

        $extraoptions = [];
        if (! is_null($this->option('path'))) {
            $extraoptions['--path'] = $this->option('path');
        }
        if (! is_null($this->option('namespace'))) {
            $extraoptions['--namespace'] = $this->option('namespace');
        }

        if ((int) $this->argument('create_model') == 1) {
            // Create migration
            // Strip namespace from migration command
            $migrationOptions = $extraoptions;
            unset($migrationOptions['--namespace']);
            $this->call(
                'motor:make:migration',
                array_merge([ 'name' => "create_{$table}_table", '--create' => $table ], $migrationOptions)
            );

            // Create model
            $extraoptions['--stub_path'] = __DIR__ . '/stubs/model.stub';
            $this->call('motor:make:model', array_merge([ 'name' => 'Component/' . $classSingular ], $extraoptions));

            // Create controller
            $extraoptions['--stub_path'] = __DIR__ . '/stubs/controller_component.stub';
            $this->call(
                'motor:make:controller',
                array_merge([ 'name' => 'Backend/Component/' . $classPlural . 'Controller' ], $extraoptions)
            );

            // Create service
            $extraoptions['--stub_path'] = __DIR__ . '/stubs/service.stub';
            $this->call(
                'motor:make:service',
                array_merge([ 'name' => 'Component/' . $classSingular . 'Service' ], $extraoptions)
            );

            // Create form
            unset($extraoptions['--stub_path']);
            $this->call(
                'motor:make:form',
                array_merge([ 'name' => 'Forms/Backend/Component/' . $classSingular . 'Form' ], $extraoptions)
            );

            $extraoptions['--stub_path'] = __DIR__ . '/stubs/views/component.blade.stub';
            $extraoptions['--directory'] = 'frontend';
            unset($extraoptions['--prefix']);
            $this->call(
                'motor:make:view',
                array_merge([ 'name' => 'component', 'type' => Str::kebab(Str::plural($this->argument('name'))) ], $extraoptions)
            );

            // Create frontend class
            unset($extraoptions['--directory']);
            unset($extraoptions['--stub_path']);
            if (isset($extraoptions['--prefix'])) {
                unset($extraoptions['--prefix']);
            }
            $this->call('motor:make:component-class', array_merge([ 'name' => $classPlural ], $extraoptions));
        } else {
            $extraoptions['--stub_path'] = __DIR__ . '/stubs/views/component_no_model.blade.stub';
            $extraoptions['--directory'] = 'frontend';
            unset($extraoptions['--prefix']);
            $this->call(
                'motor:make:view',
                array_merge([ 'name' => 'component', 'type' => Str::kebab(Str::plural($this->argument('name'))) ], $extraoptions)
            );

            // Create frontend class
            $extraoptions['--stub_path'] = __DIR__ . '/stubs/component_class_no_model.stub';
            unset($extraoptions['--directory']);
            if (isset($extraoptions['--prefix'])) {
                unset($extraoptions['--prefix']);
            }
            $this->call('motor:make:component-class', array_merge([ 'name' => $classPlural ], $extraoptions));
        }

        // Create i18n file
        $extraoptions['--stub_path'] = __DIR__ . '/stubs/i18n.stub';
        $extraoptions['--prefix']    = 'component';
        if (isset($extraoptions['--directory'])) {
            unset($extraoptions['--directory']);
        }

        $this->call(
            'motor:make:i18n',
            array_merge(
                [ 'name' => Str::plural($this->argument('name')), 'locale' => $this->argument('locale') ],
                $extraoptions
            )
        );

        // Display config information
        unset($extraoptions['--stub_path']);
        unset($extraoptions['--prefix']);
        $extraoptions['--create_model'] = (int) $this->argument('create_model');
        $this->call('motor:make:component-info', array_merge([ 'name' => $classPlural ], $extraoptions));
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            [ 'name', InputArgument::REQUIRED, 'The name of the component' ],
        ];
    }
}
