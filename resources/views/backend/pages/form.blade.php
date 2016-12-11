{!! form_start($form) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'is_active') !!}
    </div>
    <!-- /.box-body -->

    <div class="box-body">
        @foreach ($templates as $name => $template)
            <div class="template-{{$name}}">
                <h4>{{$name}}</h4>
                @include('motor-cms::layouts.partials.template-sections', ['rows' => $template])
            </div>
        @endforeach
    </div>

    <div class="box-footer">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
<div id="motor-component-modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body motor-cms-components hide">
                @foreach ($components as $sectionIdentifier => $section)
                    <h4>{{$section['name']}}</h4>
                    @foreach ($section['components'] as $componentIdentifier => $component)
                        <button data-href="{{route($component['route'])}}" data-component="{{$componentIdentifier}}"
                                class="motor-component-add btn btn-default">{{$component['name']}}
                            <br><sub>{{$component['description']}}</sub></button>
                    @endforeach
                @endforeach
            </div>
            <div class="modal-body motor-cms-component-form hide">
            </div>
            <div class="modal-footer hide">
                {{--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>--}}
                <button type="button" class="motor-component-save btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<style type="text/css">
    .motor-cms-components button {
        width: 200px;
    }

    .motor-template-section {
    }
</style>
@section('view_scripts')
    <script type="text/javascript">
        $('.motor-component-new').on('click', function (e) {
            e.preventDefault();

            $('.motor-cms-components').removeClass('hide');
            $('.motor-cms-component-form').addClass('hide');
            $('.modal-footer').addClass('hide');

            console.log('new component for container ' + $(this).data('container'));

            $('#motor-component-modal').modal();
            $('#motor-component-modal .modal-title').html('Add new component to container ' + $(this).data('container'));
        });
        $('.motor-component-add').on('click', function (e) {
            e.preventDefault();

            console.log('loading component form for component ' + $(this).data('component'));

            $.ajax({
                method: "GET",
                url: $(this).data('href')
            }).done(function (response) {
                $('.motor-cms-component-form').html(response);

                $('.motor-cms-components').addClass('hide');
                $('.motor-cms-component-form').removeClass('hide');
                $('.modal-footer').removeClass('hide');
            });
        });

        $('.motor-component-save').on('click', function (e) {
            e.preventDefault();

            $('.motor-cms-component-form form input[name="page_id"]').val({{$record->id}});

            $('.motor-cms-component-form form').submit();
        });
    </script>
@append