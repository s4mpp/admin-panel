<div class="row">
	@foreach($row->elements as $element)
		<div @class($element->class ?? [])>
			{{ $element->render($resource) }}
		</div>
	@endforeach
</div>