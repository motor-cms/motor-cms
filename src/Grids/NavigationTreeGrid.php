<?php

namespace Motor\CMS\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BooleanRenderer;

/**
 * Class NavigationTreeGrid
 * @package Motor\CMS\Grids
 */
class NavigationTreeGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('client.name', trans(trans('motor-backend::backend/clients.client')));
        $this->addColumn('name', trans('motor-cms::backend/navigations.name'));
        $this->addColumn('language.native_name', trans('motor-backend::backend/languages.language'));
        $this->addColumn('is_active', trans('motor-cms::backend/navigations.is_active'))
             ->renderer(BooleanRenderer::class);
        $this->addColumn('is_visible', trans('motor-cms::backend/navigations.is_visible'))
             ->renderer(BooleanRenderer::class);
        $this->addAction(trans('motor-cms::backend/navigation_trees.show_nodes'), 'backend.navigations.index',
            [ 'class' => 'btn-primary' ]);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.navigation_trees.edit')
             ->onCondition('parent_id', null);
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.navigation_trees.destroy')
             ->onCondition('parent_id', null);
    }
}
