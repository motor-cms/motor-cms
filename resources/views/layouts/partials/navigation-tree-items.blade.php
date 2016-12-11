@foreach($items as $item)
    <ul>
        @if ($newItem)
            <li data-jstree='{ "icon" : "fa fa-folder-open", "opened": true }' data-navigation-id="{{$item->id}}">{{$item->name}}
                @include('motor-cms::layouts.partials.navigation-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                <ul>
                    <li data-jstree='{ "icon" : "fa fa-file" }' id="navigation-item"><span class="navigation-item-name">{{ trans('motor-cms::backend/navigations.new_navigation_item') }}</span></li>
                </ul>
            </li>
        @else
            @if ($item->id == $selectedItem)
                <li data-jstree='{ "icon" : "fa fa-file" }' id="navigation-item" data-navigation-id="{{$item->id}}">{{$item->name}}
                    @include('motor-cms::layouts.partials.navigation-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                </li>
            @else
                <li data-jstree='{ "icon" : "fa fa-folder-open" }' data-navigation-id="{{$item->id}}">{{$item->name}}
                    @include('motor-cms::layouts.partials.navigation-tree-items', array('items' => $item->children, 'newItem' => false, 'selectedItem' => $selectedItem))
                </li>
            @endif
        @endif
    </ul>
@endforeach