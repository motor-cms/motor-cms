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
        return [
            'headline' => $this->headline,
            'body'     => $this->body,
            'anchor'   => $this->anchor,
            'image'    => new MediaResource($this->getFirstMedia('image')),
        ];
    }
}
