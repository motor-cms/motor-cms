@foreach($rows as $row)
    <div class="grid-x grid-margin-x">
        @foreach($row as $element)
            <div class="cell {{Illuminate\Support\Arr::get($element, 'class')}} medium-{{Illuminate\Support\Arr::get($element, 'width')}}">
                @if (Illuminate\Support\Arr::get($element, 'items'))
                    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => Illuminate\Support\Arr::get($element, 'items')])
                @endif
                @yield(Illuminate\Support\Arr::get($element, 'container'))
            </div>
        @endforeach
    </div>
@endforeach
