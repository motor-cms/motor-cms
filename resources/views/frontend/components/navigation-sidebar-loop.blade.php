@if ($navigationItem->hasChildren())
    <ul class="@if ($depth > 0) nested @endif vertical menu">
        @foreach ($navigationItem->children as $child)
            @if ($child->is_visible && $child->is_active)
                <li class="@if (in_array($child->full_slug, $activeNavigationSlugs)) is-active @endif">
                    <a href="{{ route('frontend.pages.index', ['slug' => $child->full_slug])}}">{{$child->name}}</a>
                    @if (!is_null($navigationItem) && in_array($child->full_slug, $activeNavigationSlugs))
                        @include('motor-cms::frontend.components.navigation-sidebar-loop', ['navigationItem' => $child, 'depth' => $depth+1])
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
