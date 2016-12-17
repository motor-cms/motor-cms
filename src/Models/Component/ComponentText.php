<?php

namespace Motor\CMS\Models\Component;

use Illuminate\Database\Eloquent\Model;

class ComponentText extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'headline',
        'body'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function component()
    {
        return $this->morphMany('Motor\CMS\Models\PageVersionComponent', 'component');
    }
}
