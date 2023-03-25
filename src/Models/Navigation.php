<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Kra8\Snowflake\HasShortFlakePrimary;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\Language;
use Motor\Core\Traits\Filterable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Motor\CMS\Models\Navigation
 *
 * @property int                                                              $id
 * @property int                                                              $client_id
 * @property int|null                                                         $language_id
 * @property string                                                           $name
 * @property string                                                           $slug
 * @property int|null                                                         $page_id
 * @property string                                                           $full_slug
 * @property int                                                              $is_visible
 * @property int                                                              $is_active
 * @property string                                                           $scope
 * @property int                                                              $_lft
 * @property int                                                              $_rgt
 * @property int|null                                                         $parent_id
 * @property int                                                              $created_by
 * @property int                                                              $updated_by
 * @property int|null                                                         $deleted_by
 * @property \Illuminate\Support\Carbon|null                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                  $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\Motor\CMS\Models\Navigation[] $children
 * @property-read \Motor\Backend\Models\Client                                $client
 * @property-read \Motor\Backend\Models\User                                  $creator
 * @property-read \Motor\Backend\Models\User|null                             $eraser
 * @property-read \Motor\Backend\Models\Language|null                         $language
 * @property-read \Motor\CMS\Models\Page|null                                 $page
 * @property-read \Motor\CMS\Models\Navigation|null                           $parent
 * @property-read \Motor\Backend\Models\User                                  $updater
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation d()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation filteredBy(\Motor\Core\Filter\Filter $filter, $column )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation filteredByMultiple(\Motor\Core\Filter\Filter $filter )
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\CMS\Models\Navigation newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\CMS\Models\Navigation newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\Motor\CMS\Models\Navigation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereClientId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereCreatedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereDeletedBy( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereFullSlug( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereIsActive( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereIsVisible( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereLanguageId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereLft( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation wherePageId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereParentId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereRgt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereScope( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereSlug( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Navigation whereUpdatedBy( $value )
 * @mixin \Eloquent
 */
class Navigation extends Model
{
    use Filterable;
    use BlameableTrait;
    use NodeTrait;
    use HasShortFlakePrimary;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'name',
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
        'page_id',
        'is_visible',
        'is_active',
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

    /**
     * @return array
     */
    protected function getScopeAttributes()
    {
        return ['scope'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
