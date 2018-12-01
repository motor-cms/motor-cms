<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>PAGE TITLE</title>

    <link href="{{ mix('/css/partymeister-frontend.css') }}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ asset('/css/revision2018.css') }}" rel="stylesheet" type="text/css"/>--}}
    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
<div class="grid-container">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>

<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view_scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
