@extends('laraguard::layout')

@section('title', 'Create')

@section('content')

	@livewire('form-resource', [
		'resource' => $resource
	])
@endsection
