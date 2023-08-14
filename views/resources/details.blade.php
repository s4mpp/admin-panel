@foreach($read ?? [] as $element)
	{{ $element->render($register ?? null) }}
@endforeach