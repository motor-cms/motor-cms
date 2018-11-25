<?php

namespace Motor\CMS\Models\Component;

use Motor\CMS\Models\ComponentBaseModel;
use Motor\Media\Models\FileAssociation;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Media;

class ComponentText extends ComponentBaseModel
{

    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'headline',
        'body'
    ];


    public function registerMediaConversions(Media $media = null)
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
            'preview' => $this->headline
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    function file_associations()
    {
        return $this->morphMany(FileAssociation::class, 'model');
    }

}
