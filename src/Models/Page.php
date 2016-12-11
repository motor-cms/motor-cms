<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Motor\Core\Traits\Filterable;

class Page extends Model
{

    use Eloquence;
    use Filterable;

    /**
     * Searchable columns for the Eloquence trait
     *
     * @var array
     */
    protected $searchableColumns = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'container',
        'sort_position',
        'component_type',
        'component_id',
    ];


    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    //public function components()
    //{
    //    return $this->morphMany('components', 'component');
    //}
}
