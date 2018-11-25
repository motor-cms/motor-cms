<?php

namespace Motor\CMS\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Motor\Core\Console\Commands\MotorAbstractCommand;

class MotorMakeComponentInfoCommand extends MotorAbstractCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'motor:make:component-info {name} {--path=} {--namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display config information according to the given name';


    protected function getTargetPath()
    {
    }


    protected function getTargetFile()
    {
    }


    protected function getComponentConfigurationStub()
    {
        return __DIR__ . '/stubs/info/component-configuration.stub';
    }


    protected function getRouteStub()
    {
        return __DIR__ . '/stubs/info/route.stub';
    }


    protected function getRouteModelBindingStub()
    {
        return __DIR__ . '/stubs/info/routemodelbinding.stub';
    }

    //protected function getPermissionStub()
    //{
    //    return __DIR__ . '/stubs/info/permissions.stub';
    //}

    protected function makeDirectory($directory)
    {
        $filesystem = new Filesystem();
        if ( ! $filesystem->isDirectory($directory)) {
            $filesystem->makeDirectory($directory, 0755, true);
        }
    }


    protected function replaceTemplateVars($stub)
    {
        $replaceVars = [
            'singularSnakeWithoutPrefix' => Str::snake(Str::singular(str_replace('Component', '',
                $this->argument('name')))),
            'pluralSnakeWithoutPrefix'   => Str::snake(Str::plural(str_replace('Component', '',
                $this->argument('name')))),
            'singularTitleWithoutPrefix' => Str::ucfirst(str_replace('_', ' ', (str_replace('Component', '',
                Str::singular($this->argument('name')))))),
        ];

        foreach ($replaceVars as $key => $value) {
            $stub = str_replace('{{' . $key . '}}', $value, $stub);
        }

        return parent::replaceTemplateVars($stub);
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $componentConfiguration = file_get_contents($this->getComponentConfigurationStub());
        $componentConfiguration = $this->replaceTemplateVars($componentConfiguration);

        $route = file_get_contents($this->getRouteStub());
        $route = $this->replaceTemplateVars($route);

        $routeModelBinding = file_get_contents($this->getRouteModelBindingStub());
        $routeModelBinding = $this->replaceTemplateVars($routeModelBinding);

        //$permission = file_get_contents($this->getPermissionStub());
        //$permission = $this->replaceTemplateVars($permission);

        $this->info('Add this to the components array in your app/config/motor-cms-page-components.php');
        echo $componentConfiguration . "\n";

        $this->info('Add this to the component route groups in your routes/web.php');
        echo $route . "\n";

        $this->info('Add this to the boot method in your app/Providers/RouteServiceProvider.php (or your own service provider)');
        echo $routeModelBinding . "\n";

        //$this->info('Add this to your app/config/motor-backend-permissions.php file');
        //echo $permission."\n";

        $this->info('In order to make your routes and translations available for the page manager please, execute \'php artisan ziggy:generate\' and \'php artisan vue-i18n:generate\'');
    }
}
