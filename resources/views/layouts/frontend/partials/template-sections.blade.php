@foreach($rows as $row)
    <div class="grid-x grid-margin-x">
        @foreach($row as $element)
            <div class="cell {{Arr::get($element, 'class')}} medium-{{Arr::get($element, 'width')}}">
                @if (Arr::get($element, 'items'))
                    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => Arr::get($element, 'items')])
                @endif
                @yield(Arr::get($element, 'container'))
            </div>
        @endforeach
    </div>
@endforeach
