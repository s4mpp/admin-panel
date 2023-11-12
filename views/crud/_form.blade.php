@foreach($form ?? [] as $element)
	{{ $element->render($register ?? null) }}
@endforeach