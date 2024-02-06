@extends('admin::crud.resource')

@section('title', 'Editar')

@section('title-page')
	
@endsection 

@section('content-resource')

	@livewire('form-resource', [
		'resource_name' => $resource->getName(),
		'register' => $register
	])
@endsection