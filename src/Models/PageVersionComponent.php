<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;

/**
 * Motor\CMS\Models\PageVersionComponent
 *
 * @property int                                                $id
 * @property int                                                $page_version_id
 * @property string                                             $container
 * @property int                                                $sort_position
 * @property string                                             $component_name
 * @property string                                             $component_type
 * @property string                                             $component_id
 * @property \Illuminate\Support\Carbon|null                    $created_at
 * @property \Illuminate\Support\Carbon|null                    $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $component
 * @property-read \Motor\CMS\Models\PageVersion                 $version
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent search( $q, $full_text = false )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereComponentId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereComponentName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereComponentType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereContainer( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent wherePageVersionId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereSortPosition( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\PageVersionComponent whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class PageVersionComponent extends Model
{
    use Searchable;
    use Filterable;

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function version()
    {
        return $this->belongsTo(PageVersion::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function component()
    {
        return $this->morphTo();
    }
}
