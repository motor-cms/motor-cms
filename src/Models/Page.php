<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\CMS\Traits\Versionable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Motor\Core\Traits\Searchable;

/**
 * Motor\CMS\Models\Page
 *
 * @property int                                                                           $id
 * @property int                                                                           $client_id
 * @property int|null                                                                      $language_id
 * @property int                                                                           $is_active
 * @property string                                                                        $template
 * @property string                                                                        $name
 * @property string                                                                        $meta_description
 * @property string                                                                        $meta_keywords
 * @property string                                                                        $state
 * @property int                                                                           $created_by
 * @property int                                                                           $updated_by
 * @property int|null                                                                      $deleted_by
 * @property \Illuminate\Support\Carbon|null                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                               $updated_at
 * @property-read \Motor\Backend\Models\User                                               $creator
 * @property-read \Motor\Backend\Models\User|null                                          $eraser
 * @property-read \Motor\Backend\Models\User                                               $updater
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersion[] $versions
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page filteredBy( \Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereClientId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereIsActive( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereLanguageId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereMetaDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereMetaKeywords( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereState( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereTemplate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Page whereUpdatedBy( $value )
 * @mixin \Eloquent
 */
class Page extends Model
{
    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;
    use Versionable;

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
        'client_id',
        'language_id',

        // versioned attributes need to be fillable as well so we can save the record. maybe we need to change something about that...
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
    ];

    protected $versionableColumns = [
        'versionable_state',
        'versionable_number',
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        // we need to join tables and stuff here
        return $this->hasMany(PageVersion::class, 'versionable_id');
    }
}
