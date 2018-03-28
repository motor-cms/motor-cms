@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-cms::backend/navigations.edit') }}
    {!! link_to_route('backend.navigations.index', trans('motor-backend::backend/global.back'), ['navigation' => $root->id], ['class' => 'pull-right float-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
	@include('motor-backend::errors.list')
	@include('motor-cms::backend.navigations.form')
@endsection