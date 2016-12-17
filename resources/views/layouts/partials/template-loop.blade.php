@foreach ($templates as $name => $template)
    <div class="template-{{$name}}">
        <h4>{{$name}}</h4>
        @include('motor-cms::layouts.partials.template-sections', ['rows' => $template, 'record' => $record])
    </div>
@endforeach
