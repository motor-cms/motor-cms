<h1>{{$component->headline}}</h1>
<p>
    {!! $component->body !!}
{{--    @if ($component->getFirstMedia('image'))--}}
{{--        <a href="{{$component->getFirstMedia('image')->getUrl()}}" class="thumbnail"><img src="{{$component->getFirstMedia('image')->getUrl('thumb')}}" alt=""></a>--}}
{{--    @endif--}}
</p>