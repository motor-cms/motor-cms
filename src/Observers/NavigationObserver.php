<?php

namespace Motor\CMS\Observers;

use Illuminate\Support\Facades\Cache;
use Motor\CMS\Models\Navigation;

class NavigationObserver
{
    public function saved(Navigation $navigation): void
    {
        Cache::forget('nav-main-tree');
    }

    public function deleted(Navigation $navigation): void
    {
        Cache::forget('nav-main-tree');
    }
}
