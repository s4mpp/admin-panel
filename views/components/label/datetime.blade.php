@php
	$datetime = $label->getContent($register);
@endphp

{{ $label->getDateTimeFormatted($datetime) }}

@if($date_diff = $label->getDiffForHumans($datetime))
	<span class="opacity-50">({{ $date_diff }})</span>
@endif