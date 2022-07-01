<?php

namespace Motor\CMS\Console\Commands;

use Illuminate\Console\Command;
use Motor\CMS\Models\Page;

/**
 * Class MotorCMSExportNavigationCommand
 */
class MotorCMSExportPagesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'motor:cms:export-pages';

    protected $signature = 'motor:cms:export-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export JSON representation of all live pages';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $pages = [];
        foreach (Page::all() as $page) {
            try {
                $liveVersion = $page->getLiveVersion();
            } catch (\Exception $e) {
                continue;
            }
            $newPage = $page->toArray();
            $newPage['versions'] = [$liveVersion->toArray()];
            $newPage['versions'][0]['components'] = [];
            foreach ($liveVersion->components as $component) {
                $newComponent = $component->toArray();
                if ($component['component_type'] != '') {
                    $newComponent['component'] = $component->component->toArray();
                }
                $newPage['versions'][0]['components'][] = $newComponent;
            }
            $pages[] = $newPage;
        }
        $filename = storage_path('pages_export_').date('Y-m-d_his').'.json';
        file_put_contents($filename, json_encode($pages, JSON_PRETTY_PRINT));

        $this->info('Exported pages to '.$filename);
    }
}
