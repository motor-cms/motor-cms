@foreach($rows as $row)
    <div class="grid-x grid-margin-x">
        @foreach($row as $element)
            <div class="cell {{array_get($element, 'class')}} medium-{{array_get($element, 'width')}}">
                @if (array_get($element, 'items'))
                    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => array_get($element, 'items')])
                @endif
                @yield(array_get($element, 'container'))
            </div>
        @endforeach
    </div>
@endforeach
