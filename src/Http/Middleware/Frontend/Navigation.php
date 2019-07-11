<?php

namespace Motor\CMS\Http\Middleware\Frontend;

use Closure;

/**
 * Class Navigation
 * @package Motor\CMS\Http\Middleware\Frontend
 */
class Navigation
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $activeNavigationSlug = $request->route()->parameter('slug');
        $navigationItems      = \Motor\CMS\Models\Navigation::where('scope', 'main')
                                                            ->where('parent_id', '!=', null)
                                                            ->defaultOrder()
                                                            ->get()
                                                            ->toTree();

        $activeNavigationItem         = null;
        $activeTopLevelNavigationItem = null;

        $traverse = static function ($nodes) use (&$traverse, &$activeNavigationItem, $activeNavigationSlug) {
            if ( ! is_null($activeNavigationItem)) {
                return;
            }
            foreach ($nodes as $node) {
                if ($node->full_slug == $activeNavigationSlug) {
                    $activeNavigationItem = $node;

                    return;
                }

                $traverse($node->children);
            }
        };

        $traverse($navigationItems);

        $activeNavigationSlugs = [ $activeNavigationSlug ];

        foreach ($activeNavigationItem->ancestors->reverse() as $anchor) {
            if ($anchor->full_slug != '') {
                $activeNavigationSlugs[] = $anchor->full_slug;
            }
        }
        $activeNavigationSlugs = array_reverse($activeNavigationSlugs);

        foreach ($navigationItems as $node) {
            if ($node->full_slug == $activeNavigationSlugs[0]) {
                $activeTopLevelNavigationItem = $node;
            }
        }

        \View::share('activeTopLevelNavigationItem', $activeTopLevelNavigationItem);
        \View::share('activeNavigationSlugs', $activeNavigationSlugs);
        \View::share('activeNavigationItem', $activeNavigationItem);
        \View::share('navigationItems', $navigationItems);

        return $next($request);
    }
}
