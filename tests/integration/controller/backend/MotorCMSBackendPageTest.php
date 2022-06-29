<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\CMS\Models\Page;

/**
 * Class MotorCMSBackendPageTest
 */
class MotorCMSBackendPageTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'pages',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_superadmin();

        $this->readPermission = create_test_permission_with_name('pages.read');
        $this->writePermission = create_test_permission_with_name('pages.write');
        $this->deletePermission = create_test_permission_with_name('pages.delete');

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_see_grid_without_page()
    {
        $this->visit('/backend/pages')
            ->see(trans('motor-cms::backend/pages.pages'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_page()
    {
        $record = create_test_page();
        $this->visit('/backend/pages')
            ->see(trans('motor-cms::backend/pages.pages'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_page_and_use_the_back_button()
    {
        $record = create_test_page();
        $this->visit('/backend/pages')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/pages/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/pages');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_page_and_change_values()
    {
        $record = create_test_page();

        $this->visit('/backend/pages/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Page', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-cms::backend/pages.save'));
            })
            ->see(trans('motor-cms::backend/pages.updated'))
            ->see('Updated Page')
            ->seePageIs('/backend/pages');

        $record = Page::find($record->id);
        $this->assertEquals('Updated Page', $record->name);
    }

    /** @test */
    public function can_click_the_page_create_button()
    {
        $this->visit('/backend/pages')
            ->click(trans('motor-cms::backend/pages.new'))
            ->seePageIs('/backend/pages/create');
    }

    /** @test */
    public function can_create_a_new_page()
    {
        $this->visit('/backend/pages/create')
            ->see(trans('motor-cms::backend/pages.new'))
            ->type('Create Page Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-cms::backend/pages.save'));
            })
            ->see(trans('motor-cms::backend/pages.created'))
            ->see('Create Page Name')
            ->seePageIs('/backend/pages');
    }

    /** @test */
    public function cannot_create_a_new_page_with_empty_fields()
    {
        $this->visit('/backend/pages/create')
            ->see(trans('motor-cms::backend/pages.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-cms::backend/pages.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/pages/create');
    }

    /** @test */
    public function can_modify_a_page()
    {
        $record = create_test_page();
        $this->visit('/backend/pages/'.$record->id.'/edit')
            ->see(trans('motor-cms::backend/pages.edit'))
            ->type('Modified Page Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-cms::backend/pages.save'));
            })
            ->see(trans('motor-cms::backend/pages.updated'))
            ->see('Modified Page Name')
            ->seePageIs('/backend/pages');
    }

    /** @test */
    public function can_delete_a_page()
    {
        create_test_page();

        $this->assertCount(1, Page::all());

        $this->visit('/backend/pages')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/pages')
            ->see(trans('motor-cms::backend/pages.deleted'));

        $this->assertCount(0, Page::all());
    }

    /** @test */
    public function can_paginate_page_results()
    {
        $records = create_test_page(100);
        $this->visit('/backend/pages')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/pages?page=3');
    }

    /** @test */
    public function can_search_page_results()
    {
        $records = create_test_page(10);
        $this->visit('/backend/pages')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
