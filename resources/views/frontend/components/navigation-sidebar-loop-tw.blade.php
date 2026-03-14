@if ($navigationItem->hasChildren())
    <ul class="menu menu-vertical @if ($depth > 0) ml-4 @endif">
        @foreach ($navigationItem->children as $child)
            @if ($child->is_visible && $child->is_active)
                <li class="@if (in_array($child->full_slug, $activeNavigationSlugs)) active @endif">
                    <a href="{{ route('frontend.pages.index', ['slug' => $child->full_slug])}}" class="@if (in_array($child->full_slug, $activeNavigationSlugs)) active @endif">{{$child->name}}</a>
                    @if (!is_null($navigationItem) && in_array($child->full_slug, $activeNavigationSlugs))
                        @include('motor-cms::frontend.components.navigation-sidebar-loop-tw', ['navigationItem' => $child, 'depth' => $depth+1])
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
