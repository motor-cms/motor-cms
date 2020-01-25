<h1>{{$component->headline}}</h1>
@if (is_null($file))
    {!! $component->body !!}
@else
    @if ($position === 'top')
        <div class="thumbnail">
            <a href="{{$file}}"><img src="{{$thumb}}" alt="{{$description}}"></a>
        </div>
        {!! $component->body !!}
    @elseif($position === 'bottom')
        {!! $component->body !!}
        <div class="thumbnail">
            <a href="{{$file}}"><img src="{{$thumb}}" alt="{{$description}}"></a>
        </div>
    @else
        <div class="thumbnail float-{{$position}}">
            <a href="{{$file}}"><img src="{{$thumb}}" alt="{{$description}}"></a>
        </div>
        {!! $component->body !!}
    @endif
@endif
