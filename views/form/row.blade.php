<div class="row">
	@foreach($row->elements as $element)
		<div class="col-12">
			{{ $element->render() }}
		</div>
	@endforeach
</div>