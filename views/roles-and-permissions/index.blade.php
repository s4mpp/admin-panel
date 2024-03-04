@extends('laraguard::layout')

@section('content')

	<div class="space-y-4">
		<x-element::message.flash />
		<x-element::message.error />

		@include('admin::roles-and-permissions.roles')
		
		@include('admin::roles-and-permissions.permissions-painel-admin')
		
		@include('admin::roles-and-permissions.permissions')
	
	</div>
@endsection