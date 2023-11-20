@php
	if($value)
	{
		$is_visible = Storage::exists($value);

		$exp = explode('.', $value);
		$type_file = end($exp);
	}
@endphp

@if($is_visible ?? false)
	@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
		<a href="{{ Storage::url($value) }}" target="_blank"><img src="{{ Storage::url($value) }}" alt="{{ $item->getTitle() }}" class="h-12"></a>
	@else
		<a href="{{ Storage::url($value) }}" class="font-medium hover:underline" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
	@endif
@else
	{{ $value }}
@endif