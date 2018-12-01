@extends($template['meta']['namespace'].'::layouts.frontend.'.$version->template)

@foreach ($renderedOutput as $container => $components)
    @foreach ($components as $component)
        @section($container)
            {!! $component !!}
        @append
    @endforeach
@endforeach
