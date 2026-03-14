<div class="prose max-w-none">
    @if($component->headline)<h1>{{ $component->headline }}</h1>@endif
    <div id="{{ $component->anchor }}"></div>
    @if (is_null($file))
        {!! $component->body !!}
    @else
        @if ($position === 'top')
            <div class="rounded-lg shadow not-prose mb-4">
                <a href="{{ $file }}"><img src="{{ $thumb }}" alt="{{ $description }}" class="rounded-lg"></a>
            </div>
            {!! $component->body !!}
        @elseif($position === 'bottom')
            {!! $component->body !!}
            <div class="rounded-lg shadow not-prose mt-4">
                <a href="{{ $file }}"><img src="{{ $thumb }}" alt="{{ $description }}" class="rounded-lg"></a>
            </div>
        @else
            <div class="rounded-lg shadow not-prose float-{{ $position }} @if($position === 'left') mr-4 mb-2 @else ml-4 mb-2 @endif">
                <a href="{{ $file }}"><img src="{{ $thumb }}" alt="{{ $description }}" class="rounded-lg"></a>
            </div>
            {!! $component->body !!}
            <div class="clear-both"></div>
        @endif
    @endif
</div>
