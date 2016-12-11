{!! form_start($form, ['id' => 'navigation-item']) !!}
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
            </div>
            <div class="box-body">
                {!! form_until($form, 'is_active') !!}
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                {!! form_row($form->submit) !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('motor-cms::backend/navigation_trees.navigation_tree') }}</h3>
            </div>
            <div class="box-body">
                <div id="navigation-tree">
                    @include('motor-cms::layouts.partials.navigation-tree-items', array('items' => $trees, 'newItem' => $newItem, 'selectedItem' => $selectedItem))
                </div>
            </div>
        </div>
    </div>

</div>
{!! form_end($form) !!}

@section('view_scripts')
    <link href="{{asset('plugins/jstree/themes/default/style.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{asset('plugins/jstree/jstree.min.js')}}"></script>
    <script>
        $.jstree.defaults.dnd.is_draggable = function (node) {
            var id = $(node).attr('id');
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

        var openNode = function (node) {
            var parent = $('#navigation-tree').jstree().get_parent(node);
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
            var parent = $('#navigation-tree').jstree().get_parent('navigation-item');

            $('input[name="parent_id"]').val($('#' + parent).data('navigation-id'));

            // get previous sibling (if any)
            var previousSibling = $('#navigation-tree').jstree().get_prev_dom('navigation-item', true);
            if (previousSibling !== false) {
                $('input[name="previous_sibling_id"]').val(previousSibling.data('navigation-id'));
            }

            var nextSibling = $('#navigation-tree').jstree().get_next_dom('navigation-item', true);
            if (nextSibling !== false) {
                $('input[name="next_sibling_id"]').val(nextSibling.data('navigation-id'));
            }
        });
    </script>
@append
