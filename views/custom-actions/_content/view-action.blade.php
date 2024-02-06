@extends('admin::crud.resource')

@section('title', $action_title)

@section('content-resource')
	 @include($view)
@endsection
