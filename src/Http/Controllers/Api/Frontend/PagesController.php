<?php

namespace Motor\CMS\Http\Controllers\Api\Frontend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Http\Resources\PageVersionResource;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Models\Page;

/**
 * Class PagesController
 */
class PagesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Page  $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($slug)
    {
        // Find page by slug
        $navigation = Navigation::where('scope', 'main')
            ->where('full_slug', $slug)
            ->first();

        if (is_null($navigation)) {
            return response()->json(['Navigation '.$slug.' not found'], 404);
        }

        $page = $navigation->page;

        if (is_null($page)) {
            return response()->json(['Page for navigation item '.$slug.' not found'], 404);
        }

        $version = $page->getLiveVersion();

        if (is_null($version)) {
            return response()->json(['message' => 'No live version found for navigation item '.$slug], 404);
        }

        return response()->json(new PageVersionResource($version));
    }
}
