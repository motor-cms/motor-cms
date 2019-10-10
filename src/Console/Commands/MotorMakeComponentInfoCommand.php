<?php

namespace Motor\CMS\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Motor\Core\Console\Commands\MotorAbstractCommand;

/**
 * Class MotorMakeComponentInfoCommand
 * @package Motor\CMS\Console\Commands
 */
class MotorMakeComponentInfoCommand extends MotorAbstractCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'motor:make:component-info {name} {--path=} {--namespace=} {--create_model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display config information according to the given name';


    /**
     * @return string
     */
    protected function getTargetPath(): string
    {
        return '';
    }


    /**
     * @return string
     */
    protected function getTargetFile(): string
    {
        return '';
    }


    /**
     * @return string
     */
    protected function getComponentConfigurationStub(): string
    {
        return __DIR__ . '/stubs/info/component_configuration.stub';
    }


    /**
     * @return string
     */
    protected function getComponentConfigurationNoModelStub(): string
    {
        return __DIR__ . '/stubs/info/component_configuration_no_model.stub';
    }


    /**
     * @return string
     */
    protected function getRouteStub(): string
    {
        return __DIR__ . '/stubs/info/route.stub';
    }


    /**
     * @return string
     */
    protected function getRouteModelBindingStub(): string
    {
        return __DIR__ . '/stubs/info/routemodelbinding.stub';
    }

    //protected function getPermissionStub()
    //{
    //    return __DIR__ . '/stubs/info/permissions.stub';
    //}

    /**
     * @param $directory
     */
    protected function makeDirectory($directory): void
    {
        $filesystem = new Filesystem();
        if (! $filesystem->isDirectory($directory)) {
            $filesystem->makeDirectory($directory, 0755, true);
        }
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if ((int) $this->option('create_model') == 1) {
            $componentConfiguration = file_get_contents($this->getComponentConfigurationStub());
            $componentConfiguration = $this->replaceTemplateVars($componentConfiguration);

            $this->info('Add this to the components array in your app/config/motor-cms-page-components.php');
            echo $componentConfiguration . "\n";

            $route = file_get_contents($this->getRouteStub());
            $route = $this->replaceTemplateVars($route);

            $this->info('Add this to the component route groups in your routes/web.php');
            echo $route . "\n";

            $routeModelBinding = file_get_contents($this->getRouteModelBindingStub());
            $routeModelBinding = $this->replaceTemplateVars($routeModelBinding);

            $this->info('Add this to the boot method in your app/Providers/RouteServiceProvider.php (or your own service provider)');
            echo $routeModelBinding . "\n";

            $this->info('In order to make your routes and translations available for the page manager please, execute \'php artisan ziggy:generate\' and \'php artisan vue-i18n:generate\'. If you are using the development environment please also run \'./update-dev.sh\' before running your migrations');
        } else {
            $componentConfiguration = file_get_contents($this->getComponentConfigurationNoModelStub());
            $componentConfiguration = $this->replaceTemplateVars($componentConfiguration);

            $this->info('Add this to the components array in your app/config/motor-cms-page-components.php');
            echo $componentConfiguration . "\n";

            $this->info('In order to make your translations available for the page manager please, execute \'php artisan motor:vue-i18n:generate\'');
        }

        //$permission = file_get_contents($this->getPermissionStub());
        //$permission = $this->replaceTemplateVars($permission);

        //$this->info('Add this to your app/config/motor-backend-permissions.php file');
        //echo $permission."\n";
    }
}
