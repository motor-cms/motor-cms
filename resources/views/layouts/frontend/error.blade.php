<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Oops!</title>

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
<div class="grid-container">
    @yield('main-content')
</div>
<script>
    $(document).foundation();
</script>
</body>
</html>
