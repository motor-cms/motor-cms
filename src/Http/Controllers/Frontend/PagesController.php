<?php

namespace Motor\CMS\Http\Controllers\Frontend;

use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Models\Navigation;
use Motor\CMS\Models\Page;

class PagesController extends Controller
{

    /**
     * Get current live version of the given page
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        // Find page by slug
        $navigation = Navigation::where('scope', 'main')->where('full_slug', $slug)->first();

        if (is_null($navigation)) {
            return response('Navigation ' . $slug . ' not found', 404);
        }

        $page = $navigation->page;

        if (is_null($page)) {
            return response('Page for navigation item ' . $slug . ' not found', 404);
        }

        $version = $page->getLiveVersion();

        if (is_null($version)) {
            return response('No live version found for navigation item ' . $slug, 404);
        }

        return view('motor-cms::frontend.default', compact('version'));

    }
}
