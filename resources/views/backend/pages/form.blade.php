<div id="motor-cms-component-wrapper">

    {!! form_start($form) !!}
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_until($form, 'is_active') !!}
        </div>
        <!-- /.box-body -->

        @if (isset($record))
            <div class="@boxBody">
                <div class="motor-cms-component-flash alert alert-success flash-message d-none"></div>
                <div class="motor-cms-component-container">
                    <motor-cms-template :page-id="@if (isset($record) && !is_null($record)) {{$record->id}} @else null @endif" :available-components="{{ $components }}" :template-data="@if (isset($record) && !is_null($record->getCurrentVersion())) {{ $template }} @else [] @endif"></motor-cms-template>
                </div>
            </div>
        @endif

        <div class="@boxFooter">
            {!! form_row($form->submit) !!}
            {!! form_row($form->publish) !!}
        </div>
    </div>
    {!! form_end($form) !!}

    <motor-cms-page-component-modal :page-version-id="@if (isset($record) && !is_null($record->getCurrentVersion())) {{$record->getCurrentVersion()->id}} @else null @endif" :page-id="@if (isset($record) && !is_null($record)) {{$record->id}} @else null @endif" :available-components="{{ $components }}"></motor-cms-page-component-modal>
</div>
