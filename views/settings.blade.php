@extends('laraguard::layout')

@section('content')

	<x-element::message.flash />

	@livewire('form-settings', ['url' => route($panel->getRouteName('configuracoes', 'index'))])
@endsection