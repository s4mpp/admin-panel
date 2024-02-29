@if(is_a($content, Carbon::class))
	{{ $content?->format($format)  }}
@else
	{{ $content }}
@endif