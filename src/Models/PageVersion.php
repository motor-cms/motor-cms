<?php

namespace Motor\CMS\Models;

use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;

/**
 * Motor\CMS\Models\PageVersion
 *
 * @property int                                                                                    $id
 * @property string                                                                                 $versionable_state
 * @property int                                                                                    $versionable_number
 * @property int                                                                                    $versionable_id
 * @property int                                                                                    $is_active
 * @property string                                                                                 $template
 * @property string                                                                                 $name
 * @property string                                                                                 $meta_description
 * @property string                                                                                 $meta_keywords
 * @property int                                                                                    $created_by
 * @property int                                                                                    $updated_by
 * @property int|null                                                                               $deleted_by
 * @property \Illuminate\Support\Carbon|null                                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                                        $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersionComponent[] $components
 * @property-read \Motor\Backend\Models\User                                                        $creator
 * @property-read \Motor\Backend\Models\User|null                                                   $eraser
 * @property-read \Motor\Backend\Models\User                                                        $updater
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereIsActive( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereMetaDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereMetaKeywords( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereTemplate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereUpdatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereVersionableId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereVersionableNumber( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersion whereVersionableState( $value )
 * @mixin \Eloquent
 */
class PageVersion extends Model
{
    use Searchable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    protected $blameable = ['created', 'updated', 'deleted'];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = ['name'];

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
        'state',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function components()
    {
        return $this->hasMany(PageVersionComponent::class);
    }
}
