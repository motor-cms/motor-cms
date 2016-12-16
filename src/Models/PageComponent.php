<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class PageComponent extends Model
{

    use Eloquence;
    use Filterable;

    //use Blameable, CreatedBy, UpdatedBy, DeletedBy

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    //protected $blameable = [ 'created', 'updated', 'deleted' ];

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


    public function components()
    {
        return $this->morphTo();
    }
}
