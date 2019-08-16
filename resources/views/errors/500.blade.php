@extends('motor-cms::layouts.frontend.error')

@section('htmlheader_title')
    Server error
@endsection

@section('contentheader_title')
    500 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h1>Something went wrong.</h1>
        <div class="error-content">
            <h3>Oops!</h3>
            <p>
                We will work on fixing that right away.
                Meanwhile, you may <a href='{{ url('/start') }}'>return to the start page</a>.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

@endsection