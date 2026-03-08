<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>PAGE TITLE</title>

    @vite(['resources/assets/sass/partymeister-frontend.package-development.scss'])
    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.navigation')
<div class="grid-container">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>

@vite(['resources/assets/js/frontend.js'])
@yield('view-scripts')
<script type="module">
    $(document).foundation();
</script>
</body>
</html>
