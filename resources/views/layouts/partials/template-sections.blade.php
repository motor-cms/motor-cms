@foreach ($rows as $row)
    <div class="row">
        @foreach ($row as $element)
            <div class="motor-template-section col-md-{{$element['width']}}@if (isset($element['class'])) {{$element['class']}}@endif">
                @if (isset($element['items']))
                    @include('motor-cms::layouts.partials.template-sections', ['rows' => $element['items']])
                @else
                    <div class="alert alert-info">
                        <b>{{$element['alias']}}</b>
                        <button data-container="{{$element['container']}}"
                                class="btn btn-xs btn-default pull-right motor-component-new"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endforeach