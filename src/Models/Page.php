<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class Page extends Model
{

    use Eloquence;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the Eloquence trait
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
        'client_id',
        'language_id',
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
        'state'
    ];

    public function components()
    {
        return $this->hasMany(PageComponent::class);
    }
}
