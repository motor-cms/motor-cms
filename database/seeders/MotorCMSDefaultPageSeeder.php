<?php

namespace Motor\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Motor\CMS\Models\Page;

/**
 * Class MotorMediaDefaultCategorySeeder
 */
class MotorCMSDefaultPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'client_id'   => \Motor\Backend\Models\Client::first()->id,
            'language_id' => \Motor\Backend\Models\Language::first()->id,
            'template'    => 'default',
            'is_active'   => true,
            'name'        => 'Start',
            'created_by'  => 1,
            'updated_by'  => 1,
        ]);

        DB::table('page_versions')->insert([
            'versionable_state'  => 'LIVE',
            'versionable_number' => 1,
            'versionable_id'     => Page::first()->id,
            'is_active'          => true,
            'template'           => 'default',
            'name'               => 'Start',
            'created_by'         => 1,
            'updated_by'         => 1,
        ]);

        DB::table('component_texts')->insert([
            'headline' => 'My first page',
            'body'     => '<p>This is my first page made with Motor-CMS!</p>',
        ]);

        DB::table('page_version_components')->insert([
            'page_version_id' => \Motor\CMS\Models\PageVersion::first()->id,
            'container'       => 'first-row-content',
            'sort_position'   => 1,
            'component_name'  => 'text',
            'component_type'  => 'Motor\CMS\Models\Component\ComponentText',
            'component_id'    => \Motor\CMS\Models\Component\ComponentText::first()->id,
        ]);
    }
}
