@extends('motor-cms::layouts.frontend.error')

@section('htmlheader_title')
    Access denied
@endsection

@section('contentheader_title')
    403 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h1>You don't have access to this page.</h1>
        <div class="error-content">
            <h3>Oops!</h3>
            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href='{{ url('/start') }}'>return to the start page</a>.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

@endsection