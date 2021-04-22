<?php

namespace Motor\CMS\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;
use Motor\Backend\Http\Resources\MediaResource;

class ComponentTextResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $media = null;
        $fileAssociation = $this->file_associations()
                                ->where('identifier', 'image')
                                ->first();

        if (! is_null($fileAssociation)) {
            $media = $fileAssociation->file->getFirstMedia('file');
        }

        return [
            'headline' => $this->headline,
            'body'     => $this->body,
            'anchor'   => $this->anchor,
            'image'    => $this->when($media, new MediaResource($media)),
        ];
    }
}
