@foreach($form->elements ?? [] as $element)
	{{ $element->render($register ?? null) }}
@endforeach