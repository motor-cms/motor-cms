<?php

namespace Motor\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Motor\Backend\Models\Client;
use Motor\CMS\Models\Page;

/**
 * Class MotorMediaDefaultCategorySeeder
 */
class MotorCMSDefaultPageNavigationTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $node = \Motor\CMS\Models\Navigation::create([
            'name'       => 'Main navigation',
            'scope'      => 'main',
            'client_id'  => Client::first()->id,
            'created_by' => 1,
            'updated_by' => 1,
            'children'   => [
                [
                    'name'       => 'Start',
                    'scope'      => 'main',
                    'slug'       => 'start',
                    'full_slug'  => 'start',
                    'client_id'  => Client::first()->id,
                    'page_id'    => Page::first()->id,
                    'is_visible' => true,
                    'is_active'  => true,
                    'created_by' => 1,
                    'updated_by' => 1,
                ],
            ],
        ]);
    }
}
