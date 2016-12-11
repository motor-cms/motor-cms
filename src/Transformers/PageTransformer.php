<?php

namespace Motor\CMS\Transformers;

use League\Fractal;
use Motor\CMS\Models\Page;

class PageTransformer extends Fractal\TransformerAbstract
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
     * @param Page $record
     *
     * @return array
     */
    public function transform(Page $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
