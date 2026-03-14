<nav class="space-y-2">
    @include('motor-cms::frontend.components.navigation-sidebar-loop-tw', [
        'items' => $activeTopLevelNavigationItem->children,
        'depth' => 0
    ])
</nav>
