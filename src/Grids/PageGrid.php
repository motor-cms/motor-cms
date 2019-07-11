<?php

namespace Motor\CMS\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class PageGrid
 * @package Motor\CMS\Grids
 */
class PageGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('name', trans('motor-cms::backend/pages.name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.pages.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.pages.destroy');
    }
}
