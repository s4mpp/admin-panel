@extends('admin::layout')

@section('title', $title)

@section('title-page')
	<a href="{{ route($action_routes['index']) }}" class="btn btn-secondary me-2"><i class="la la-chevron-left"></i> Voltar</a>

	@isset($resource_actions)
		@php
			$id = $register->id ?? null;
		@endphp
		<x-admin-actions local="read" class="btn me-2" element="btn" :actions=$resource_actions :actionRoutes=$action_routes :id=$id />
	@endisset
@endsection

@section('content')

	@yield('content-resource')
@endsection
