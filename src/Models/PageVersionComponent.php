<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class PageVersionComponent extends Model
{

    use Searchable;
    use Filterable;

    //use Blameable, CreatedBy, UpdatedBy, DeletedBy

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    //protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
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
        'page_version_id',
        'container',
        'sort_position',
        'component_type',
        'component_id',
    ];


    public function version()
    {
        return $this->belongsTo(PageVersion::class);
    }


    public function component()
    {
        return $this->morphTo();
    }
}
