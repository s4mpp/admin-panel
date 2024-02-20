@extends('laraguard::layout')

@section('title', 'Editar')

@section('title-page')
	
@endsection 

@section('content')

	@livewire('form-resource', [
		'resource' => $resource,
		'register' => $register
	])
@endsection