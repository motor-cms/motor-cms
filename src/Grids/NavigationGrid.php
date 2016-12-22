<?php

namespace Motor\CMS\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BooleanRenderer;
use Motor\CMS\Grid\Renderers\TreeRenderer;

class NavigationGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('name', trans('motor-cms::backend/navigations.name'))->renderer(TreeRenderer::class);
        $this->addColumn('is_active', trans('motor-cms::backend/navigations.is_active'))->renderer(BooleanRenderer::class);
        $this->addColumn('is_visible', trans('motor-cms::backend/navigations.is_visible'))->renderer(BooleanRenderer::class);

        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.navigations.edit')->onCondition('parent_id', null, '!=');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.navigations.destroy')->onCondition('parent_id', null, '!=');
    }
}
