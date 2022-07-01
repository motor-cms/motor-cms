<?php

namespace Motor\CMS\Http\Controllers\Frontend;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Models\Navigation;

/**
 * Class PagesController
 */
class PagesController extends Controller
{
    /**
     * Get current live version of the given page
     *
     * @param $slug
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View|object
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index($slug)
    {
        // Find page by slug
        $navigation = Navigation::where('scope', 'main')->where('full_slug', $slug)->first();

        if (is_null($navigation)) {
            return response('Navigation '.$slug.' not found', 404);
        }

        $page = $navigation->page;

        if (is_null($page)) {
            return response('Page for navigation item '.$slug.' not found', 404);
        }

        $version = $page->getLiveVersion();

        if (is_null($version)) {
            return response('No live version found for navigation item '.$slug, 404);
        }

        $renderedOutput = [];

        foreach ($version->components()->orderBy('container')->orderBy('sort_position')->get() as $pageComponent) {
            if (! isset($renderedOutput[$pageComponent->container])) {
                $renderedOutput[$pageComponent->container] = [];
            }
            $result = \Motor\CMS\Services\ComponentBaseService::render($pageComponent);
            if ($result instanceof View) {
                $renderedOutput[$pageComponent->container][] = $result;
            } elseif ($result instanceof RedirectResponse) {
                return $result;
            }
        }

        $template = config('motor-cms-page-templates.'.$version->template);

        return view('motor-cms::frontend.default', compact('template', 'version', 'renderedOutput'));
    }
}
