{!! form_start($form, ['id' => 'navigation-item']) !!}
<div class="row">
    <div class="col-md-8">
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_until($form, 'is_active') !!}
            </div>
            <!-- /.box-body -->

            <div class="@boxFooter">
                {!! form_row($form->submit) !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('motor-cms::backend/navigation_trees.navigation_tree') }}</h3>
            </div>
            <div class="@boxBody">
                <div id="navigation-tree">
                    @include('motor-cms::layouts.partials.navigation-tree-items', array('items' => $trees, 'newItem' => $newItem, 'selectedItem' => $selectedItem))
                </div>
            </div>
        </div>
    </div>

</div>
{!! form_end($form) !!}

@section('view_scripts')
{{--    <link href="{{asset('plugins/jstree/themes/default/style.css')}}" rel="stylesheet" type="text/css"/>--}}
{{--    <script src="{{asset('plugins/jstree/jstree.min.js')}}"></script>--}}
    <script>
        $.jstree.defaults.dnd.is_draggable = function (node) {
            let id = $(node).attr('id');
            if (id != 'navigation-item') {
                return false;
            }
            return true;
        };

        $('#navigation-tree').jstree(
            {
                "core": {
                    "check_callback": true
                },
                "plugins": ["dnd"]
            }
        );

        $(document).on('dnd_stop.vakata', function (event, element) {
            $.each(element.data.nodes, function (index, node) {
                setTimeout(function () {
                    openNode(node)
                }, 500);
            });
        });

        let openNode = function (node) {
            let parent = $('#navigation-tree').jstree().get_parent(node);
            $('#navigation-tree').jstree().open_node(parent);

            if (parent) {
                openNode(parent);
            }
        };

        openNode('navigation-item');

        $('input#name').keyup(function (e) {
            $('#navigation-item a span.navigation-item-name').html($(this).val());
        });
        $('form#navigation-item').on('submit', function (e) {
//            e.preventDefault();

            // get item parent
            let parent = $('#navigation-tree').jstree().get_parent('navigation-item');

            $('input[name="parent_id"]').val($('#' + parent).data('navigation-id'));

            // get previous sibling (if any)
            let previousSibling = $('#navigation-tree').jstree().get_prev_dom('navigation-item', true);
            if (previousSibling !== false) {
                $('input[name="previous_sibling_id"]').val(previousSibling.data('navigation-id'));
            }

            let nextSibling = $('#navigation-tree').jstree().get_next_dom('navigation-item', true);
            if (nextSibling !== false) {
                $('input[name="next_sibling_id"]').val(nextSibling.data('navigation-id'));
            }
        });
    </script>
@append
