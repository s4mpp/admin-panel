@extends('admin::resources.resource')

@section('title', $title.' / Visualizar')

@section('content-resource')

<x-card title="">
	<div class="row">
		<div class="col-sm-8">
			@include('admin::resources.details')
		</div>
		<div class="col-sm-4">
			<x-item-view title="ID">#{{ $register->id}}</x-item-view>
			
			<x-item-view title="Alterado em">{{ $register->updated_at->format('d/m/Y H:i') }} ({{ $register->updated_at->diffForHumans() }})</x-item-view>
			
			<x-item-view title="Cadastrado em">{{ $register->created_at->format('d/m/Y H:i') }} ({{ $register->updated_at->diffForHumans() }})</x-item-view>
		</div>
	</div>
</x-card>
	 
@endsection
