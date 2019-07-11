<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\CMS\Models\Navigation;

/**
 * Class MotorCMSBackendNavigationTest
 */
class MotorCMSBackendNavigationTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'navigations',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media'
    ];


    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('navigations.read');
        $this->writePermission  = create_test_permission_with_name('navigations.write');
        $this->deletePermission = create_test_permission_with_name('navigations.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_navigation()
    {
        $this->visit('/backend/navigations')
            ->see(trans('motor-cms::backend/navigations.navigations'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_navigation()
    {
        $record = create_test_navigation();
        $this->visit('/backend/navigations')
            ->see(trans('motor-cms::backend/navigations.navigations'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_navigation_and_use_the_back_button()
    {
        $record = create_test_navigation();
        $this->visit('/backend/navigations')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/navigations/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/navigations');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_navigation_and_change_values()
    {
        $record = create_test_navigation();

        $this->visit('/backend/navigations/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Navigation', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-cms::backend/navigations.save'));
            })
            ->see(trans('motor-cms::backend/navigations.updated'))
            ->see('Updated Navigation')
            ->seePageIs('/backend/navigations');

        $record = Navigation::find($record->id);
        $this->assertEquals('Updated Navigation', $record->name);
    }

    /** @test */
    public function can_click_the_navigation_create_button()
    {
        $this->visit('/backend/navigations')
            ->click(trans('motor-cms::backend/navigations.new'))
            ->seePageIs('/backend/navigations/create');
    }

    /** @test */
    public function can_create_a_new_navigation()
    {
        $this->visit('/backend/navigations/create')
            ->see(trans('motor-cms::backend/navigations.new'))
            ->type('Create Navigation Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-cms::backend/navigations.save'));
            })
            ->see(trans('motor-cms::backend/navigations.created'))
            ->see('Create Navigation Name')
            ->seePageIs('/backend/navigations');
    }

    /** @test */
    public function cannot_create_a_new_navigation_with_empty_fields()
    {
        $this->visit('/backend/navigations/create')
            ->see(trans('motor-cms::backend/navigations.new'))
            ->within('.box-footer', function(){
                $this->press(trans('motor-cms::backend/navigations.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/navigations/create');
    }

    /** @test */
    public function can_modify_a_navigation()
    {
        $record = create_test_navigation();
        $this->visit('/backend/navigations/'.$record->id.'/edit')
            ->see(trans('motor-cms::backend/navigations.edit'))
            ->type('Modified Navigation Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-cms::backend/navigations.save'));
            })
            ->see(trans('motor-cms::backend/navigations.updated'))
            ->see('Modified Navigation Name')
            ->seePageIs('/backend/navigations');
    }

    /** @test */
    public function can_delete_a_navigation()
    {
        create_test_navigation();

        $this->assertCount(1, Navigation::all());

        $this->visit('/backend/navigations')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/navigations')
            ->see(trans('motor-cms::backend/navigations.deleted'));

        $this->assertCount(0, Navigation::all());
    }

    /** @test */
    public function can_paginate_navigation_results()
    {
        $records = create_test_navigation(100);
        $this->visit('/backend/navigations')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/navigations?page=3');
    }

    /** @test */
    public function can_search_navigation_results()
    {
        $records = create_test_navigation(10);
        $this->visit('/backend/navigations')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
