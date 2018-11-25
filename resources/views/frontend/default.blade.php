@extends('motor-cms::layouts.frontend.'.$version->template)

@foreach($version->components()->orderBy('container')->orderBy('sort_position')->get() as $pageComponent)
    @section($pageComponent->container)
        {!! \Motor\CMS\Services\ComponentBaseService::render($pageComponent) !!}
    @append
@endforeach
