<div class="flex flex-col md:flex-row w-full bg-slate-200">
	@foreach($row->elements as $element)
		<div @class($element->class ?? [])>
			{{ $element->render($resource) }}
		</div>
	@endforeach
</div>