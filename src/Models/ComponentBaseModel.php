<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentBaseModel extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function component()
    {
        return $this->morphMany('Motor\CMS\Models\PageVersionComponent', 'component');
    }
}
