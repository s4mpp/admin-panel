@extends('admin::layout')

@section('title', 'Configurações')

@section('content')
	@livewire('form-settings', ['register' => $register])
@endsection