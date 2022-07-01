<?php

namespace Motor\CMS\Console\Commands;

use Illuminate\Console\Command;
use Motor\CMS\Models\Navigation;

/**
 * Class MotorCMSExportNavigationCommand
 */
class MotorCMSExportNavigationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motor:cms:export-navigation';

    protected $signature = 'motor:cms:export-navigation {scope}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export JSON representation of the give navigation scope';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $root = Navigation::where('scope', $this->argument('scope'))->whereIsRoot()->first();

        $export = $root->toArray();
        $export['children'] = [];

        $traverse = function ($nodes, $export) use (&$traverse) {
            foreach ($nodes as $node) {
                $export[$node->id] = $node->toArray();
                $export[$node->id]['children'] = [];
                $export[$node->id]['children'] = $traverse($node->children, $export[$node->id]['children']);
            }

            return $export;
        };

        $export['children'] = $traverse($root->children, $export['children']);

        $filename = storage_path('navigation_export_').$this->argument('scope').'_'.date('Y-m-d_his').'.json';
        file_put_contents($filename, json_encode($export, JSON_PRETTY_PRINT));

        $this->info('Exported navigation scope '.$this->argument('scope').' to '.$filename);
    }
}
