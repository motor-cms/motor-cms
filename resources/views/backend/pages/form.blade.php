{!! form_start($form) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="box-body">
        {!! form_until($form, 'is_active') !!}
    </div>
    <!-- /.box-body -->

    @if (isset($record))
        <div class="box-body">
            <div class="motor-cms-component-flash alert alert-success flash-message hide"></div>
            <div class="motor-cms-component-container">
                @include('motor-cms::layouts.partials.template-loop', ['templates' => $templates, 'page' => $record])
            </div>
        </div>
    @endif

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
                @foreach ($components['groups'] as $groupIdentifier => $group)
                    <h4>{{$group['name']}}</h4>
                    @foreach ($components['components'] as $componentIdentifier => $component)
                        @if ($component['group'] == $groupIdentifier)
                            <button data-href="{{route($component['route'].'.create')}}" data-component="{{$componentIdentifier}}"
                                    class="motor-component-add btn btn-default">{{$component['name']}}
                                <br><sub>{{$component['description']}}</sub></button>
                        @endif
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
        $(document).on('click', '.motor-component-new', function(e) {
            e.preventDefault();

            $('.motor-cms-components').removeClass('hide');
            $('.motor-cms-component-form').addClass('hide');
            $('.modal-footer').addClass('hide');

            $('.motor-cms-components').data('container', $(this).data('container'));

            console.log('new component for container ' + $(this).data('container'));

            $('#motor-component-modal').modal();
            $('#motor-component-modal .modal-title').html('Add new component to container ' + $(this).data('container'));
        });

        $(document).on('click', '.motor-component-add', function(e){
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

        $(document).on('click', '.motor-component-edit', function(e){
            e.preventDefault();

            console.log('loading component form for component ' + $(this).data('component'));

            $.ajax({
                method: "GET",
                url: $(this).data('href')
            }).done(function (response) {
                $('#motor-component-modal').modal();

                $('.motor-cms-component-form').html(response);

                $('.motor-cms-components').addClass('hide');
                $('.motor-cms-component-form').removeClass('hide');
                $('.modal-footer').removeClass('hide');
            });
        });

        $(document).on('click', '.motor-component-delete', function(e){
            e.preventDefault();

            if (!confirm('{{trans('motor-cms::backend/pages.delete_component_question')}}')) {
                return false;
            }

            $.ajax({
                method: "POST",
                url: $(this).data('href'),
                data: {'_method': 'DELETE', '_token': $('input[name="_token"]').val()}
            }).done(function (response) {
                reloadComponentContainer();
                $('.motor-cms-component-flash').html(response.message).removeClass('hide').css('display', '').delay(3000).fadeOut(350);
            });
        });

        $('.motor-component-save').on('click', function (e) {
            e.preventDefault();

            @if (isset($record))
                $('.motor-cms-component-form form input[name="page_id"]').val({{$record->id}});
            $('.motor-cms-component-form form input[name="container"]').val($('.motor-cms-components').data('container'));
            @endif

            var form = $('.motor-cms-component-form form');

            $.ajax({
                method: "POST",
                data: $(form).serialize(),
                url: $(form).attr('action')
            }).done(function (response) {
                $('#motor-component-modal').modal('hide');
                reloadComponentContainer();
                $('.motor-cms-component-flash').html(response.message).removeClass('hide').css('display', '').delay(3000).fadeOut(350);
            });

        });

        @if (isset($record))
        var reloadComponentContainer = function(){
            $.ajax({
                method: "GET",
                url: '{{route('backend.pages.components.read', [$record->id])}}'
            }).done(function (response) {
                $('.motor-cms-component-container').html(response);
            });
        };
        @endif
    </script>
@append