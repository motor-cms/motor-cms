<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Motor\CMS\Models\ComponentBaseModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersionComponent[] $component
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\ComponentBaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\ComponentBaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\ComponentBaseModel query()
 * @mixin \Eloquent
 */
class ComponentBaseModel extends Model
{

    use HasUuids;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function component()
    {
        return $this->morphMany('Motor\CMS\Models\PageVersionComponent', 'component');
    }
}
