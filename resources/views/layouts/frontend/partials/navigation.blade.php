<div class="top-bar">
    <div class="contain">
        <div class="top-bar-left">
            <ul class="dropdown menu" data-dropdown-menu>
                <li class="menu-text">{{config('motor-cms-frontend.name')}}</li>
                @foreach($navigationItems as $item)
                    @if ($item->is_visible && $item->is_active)
                        <li class=" @if($activeNavigationSlugs[0] == $item->full_slug) active @endif">
                            <a href="{{ route('frontend.pages.index', ['slug' => $item->full_slug])}}">{{$item->name}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<br>
<div class="grid-container">
    <div class="row columns">
        <nav aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                @foreach($activeNavigationItem->ancestors as $item)
                    @if (!$loop->first)
                        <li>
                            <a href="{{ route('frontend.pages.index', ['slug' => $item->full_slug])}}">{{$item->name}}</a>
                        </li>
                    @endif
                @endforeach
                <li class="disabled">{{$activeNavigationItem->name}}</li>
            </ul>
        </nav>
    </div>
</div>