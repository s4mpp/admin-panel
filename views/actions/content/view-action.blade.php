@extends('admin::resources.resource')

@section('title', $action_title)

@section('content-resource')
	 @include($view)
@endsection
