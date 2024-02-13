@php
	if($content)
	{
		$is_visible = Storage::exists($content);

		$exp = explode('.', $content);
		$type_file = end($exp);
	}
@endphp

@if($is_visible ?? false)
	@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
		<a href="{{ Storage::url($content) }}" target="_blank"><img src="{{ Storage::url($content) }}" alt="{{ $item->getTitle() }}" class="h-12"></a>
	@else
		<a href="{{ Storage::url($content) }}" class="font-medium hover:underline" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
	@endif
@else
	{{ $content }}
@endif