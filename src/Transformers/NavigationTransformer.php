<?php

namespace Motor\CMS\Transformers;

use League\Fractal;
use Motor\CMS\Models\Navigation;

class NavigationTransformer extends Fractal\TransformerAbstract
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
     * @param Navigation $record
     *
     * @return array
     */
    public function transform(Navigation $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
