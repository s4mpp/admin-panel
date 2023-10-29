@extends('admin::resources.resource')

@section('title', $action_title)

@section('title-page')

@endsection 

@section('content-resource')
	 @include($view)
@endsection
