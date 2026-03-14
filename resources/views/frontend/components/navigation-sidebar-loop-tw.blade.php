<ul class="space-y-0.5 @if($depth > 0) ml-4 @endif">
    @foreach($items as $item)
        @if ($item->is_visible && $item->is_active)
            <li>
                <a href="{{ route('frontend.pages.index', ['slug' => $item->full_slug]) }}"
                   class="block px-3 py-2 rounded-md text-sm transition-colors
                          @if(in_array($item->full_slug, $activeNavigationSlugs))
                              text-heading bg-surface-raised font-medium
                          @else
                              text-text hover:text-heading hover:bg-surface-raised
                          @endif">
                    {{ $item->name }}
                </a>
                @if($item->children && $item->children->count() > 0)
                    @include('motor-cms::frontend.components.navigation-sidebar-loop-tw', [
                        'items' => $item->children,
                        'depth' => $depth + 1
                    ])
                @endif
            </li>
        @endif
    @endforeach
</ul>
