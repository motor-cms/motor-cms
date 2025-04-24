<?php

namespace Motor\CMS\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Motor\CMS\Models\PageVersionComponent;

/**
 * Class ComponentTexts
 */
class ComponentTexts
{
    protected $component;

    protected $pageVersionComponent;

    /**
     * ComponentTexts constructor.
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        \Motor\CMS\Models\Component\ComponentText $component
    ) {
        $this->component = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->render();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $thumb = $file = $position = $enlarge = $description = null;
        $image = $this->component->file_associations()->where('identifier', 'image')->first();

        if ($image) {
            // If we have a cropped image, load that one from the disk
            // if (Arr::get($image->custom_properties, 'crop')) {
            //    $hash = Arr::get($image->custom_properties, 'crop.x1').Arr::get($image->custom_properties, 'crop.x2').Arr::get($image->custom_properties, 'crop.y1').Arr::get($image->custom_properties, 'crop.y2');
            //
            //    $pathinfo = pathinfo(public_path().$image->file->getFirstMedia('file')->getUrl());
            //    $thumb = str_replace(public_path(), '', $pathinfo['dirname']).'/conversions/'.$pathinfo['filename'].'-'.md5($hash).'.jpg';
            //    $file = $thumb;
            // } else {
            $thumb = $image->file->getFirstMedia('file')->getUrl('thumb');
            $file = $image->file->getFirstMedia('file')->getUrl();
            // }

            $position = Arr::get($image->custom_properties, 'position', 'right');
            $enlarge = Arr::get($image->custom_properties, 'enlarge', false);
            $description = Arr::get($image->custom_properties, 'description', '');
        }

        return view(
            config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'),
            [
                'component' => $this->component,
                'thumb' => $thumb,
                'file' => $file,
                'position' => $position,
                'enlarge' => $enlarge,
                'description' => $description,
            ]
        );
    }
}
