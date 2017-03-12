<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\Language;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class Navigation extends Model
{

    use Filterable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use NodeTrait;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'language_id',
        'name',
        'scope',
        'is_visible',
        'is_active'
    ];

    /**
     * Get searchable columns defined on the model.
     *
     * @return array
     */
    public function getSearchableColumns()
    {
        return (property_exists($this, 'searchableColumns')) ? $this->searchableColumns : [];
    }

    protected function getScopeAttributes()
    {
        return [ 'scope' ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
