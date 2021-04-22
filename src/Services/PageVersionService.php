<?php

namespace Motor\CMS\Services;

use Motor\Backend\Services\BaseService;
use Motor\CMS\Models\PageVersion;

/**
 * Class PageVersionService
 *
 * @package Motor\CMS\Services
 */
class PageVersionService extends BaseService
{
    protected $model = PageVersion::class;
}
