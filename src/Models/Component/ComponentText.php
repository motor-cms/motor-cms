<?php

namespace Motor\CMS\Models\Component;

use Kra8\Snowflake\HasShortFlakePrimary;
use Motor\CMS\Models\ComponentBaseModel;
use Motor\Media\Models\FileAssociation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Motor\CMS\Models\Component\ComponentText
 *
 * @property int                                                                                    $id
 * @property string                                                                                 $headline
 * @property string                                                                                 $body
 * @property \Illuminate\Support\Carbon|null                                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                                        $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\CMS\Models\PageVersionComponent[] $component
 * @property-read \Illuminate\Database\Eloquent\Collection|\Motor\Media\Models\FileAssociation[]    $file_associations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[]      $media
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText whereBody( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText whereHeadline( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Motor\CMS\Models\Component\ComponentText whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class ComponentText extends ComponentBaseModel implements HasMedia
{
    use InteractsWithMedia;
    use HasShortFlakePrimary;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'headline',
        'anchor',
        'body',
    ];

    /**
     * @param  Media|null  $media
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(320)->height(240)->nonQueued();

        $this->addMediaConversion('preview')->width(1280)->height(1024)->nonQueued();
    }

    /**
     * Preview function for the page editor
     *
     * @return mixed
     */
    public function preview()
    {
        return [
            'name'    => trans('motor-cms::component/texts.component'),
            'preview' => $this->headline,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function file_associations()
    {
        return $this->morphMany(FileAssociation::class, 'model');
    }
}
