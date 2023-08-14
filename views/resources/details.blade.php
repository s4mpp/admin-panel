@foreach($read->elements ?? [] as $element)
	{{ $element->render($register ?? null) }}
@endforeach