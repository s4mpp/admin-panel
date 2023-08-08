<x-card title="">
	<div class="card-body pb-0">
		<div class="row">
			@foreach($form->fields ?? [] as $field)
				<div class="col-12">
					<x-input type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}"></x-input>
				</div>
			@endforeach
		</div>
	</div>
</x-card>