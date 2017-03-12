<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class PageVersion extends Model
{

    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'name' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
        'state'
    ];


    public function components()
    {
        return $this->hasMany(PageVersionComponent::class);
    }
}
