<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Oops!</title>

    @vite(['resources/assets/sass/partymeister-frontend.package-development.scss', 'resources/assets/js/frontend.js'])
    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
<div class="grid-container">
    @yield('main-content')
</div>
<script type="module">
    $(document).foundation();
</script>
</body>
</html>
