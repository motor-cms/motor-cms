<?php

namespace Motor\CMS\Http\Controllers\Api\Frontend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Models\Page;
use Motor\CMS\Transformers\Frontend\PageVersionTransformer;

/**
 * Class PagesController
 * @package Motor\CMS\Http\Controllers\Api
 */
class PagesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param Page $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($slug)
    {
        // Find page by slug
        $navigation = Navigation::where('scope', 'main')->where('full_slug', $slug)->first();

        if (is_null($navigation)) {
            return $this->respondWithJson('Navigation ' . $slug . ' not found', 404);
        }

        $page = $navigation->page;

        if (is_null($page)) {
            return $this->respondWithJson('Page for navigation item ' . $slug . ' not found', 404);
        }

        $version = $page->getLiveVersion();

        if (is_null($version)) {
            return $this->respondWithJson('No live version found for navigation item ' . $slug, 404);
        }

        $resource = $this->transformItem($version, PageVersionTransformer::class);

        return $this->respondWithJson('Page version read successfully', $resource);
    }
}
