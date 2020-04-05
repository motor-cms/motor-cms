<?php

namespace Motor\CMS\Transformers\Components;

use League\Fractal;
use Motor\Backend\Helpers\MediaHelper;
use Motor\CMS\Models\Page;
use Motor\CMS\Models\PageVersionComponent;

/**
 * Class PageTransformer
 * @package Motor\CMS\Transformers
 */
class TextTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @param  Page  $record
     *
     * @return array
     */
    public function transform(PageVersionComponent $record)
    {
        $imageData     = null;
        $componentData = $record->component;
        $image         = $componentData->file_associations()->where('identifier', 'image')->first();
        if ($image) {
            $imageData = MediaHelper::getFileInformation($image->file, 'file');
        }

        $data = [
            'component' => $record->component_name,
            'container'      => $record->container,
            'content'           => [
                'headline' => $componentData->headline,
                'body'     => $componentData->body,
                'image'    => $imageData,
            ],
        ];

        return $data;

    }
}
