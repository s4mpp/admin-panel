@extends('admin::layout', ['breadcrumbs' => [
	[$title, route($routes['index'])],
	['#'.$register->id, route($routes['read'], ['id' => $register->id])],
]])

@section('title', $title)

@section('content')

	@yield('content-resource')
@endsection