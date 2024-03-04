<div class="flex items-center gap-4 justify-between">
	<div class="text-center">
		<label for="file-upload-{{ $input->getName() }}" class="mb-2 relative cursor-pointer rounded-md bg-gray-100 p-2 hover:bg-gray-200 transition-colors ">
			<span class="font-semibold">Selecionar arquivo</span>
			<input wire:model="{{ $input->getNameWithPrefix() }}" id="file-upload-{{ $input->getName() }}" name="file-upload-{{ $input->getName() }}" type="file" class="sr-only">
		</label>
		<div class="clear-both"></div>
		<div class="text-[10px] pt-1">Tamanho máximo: {{ $input->getMaxFileSize() }}</div>
	</div>
	<div>
		@if($file)
			@if(method_exists($file, 'isPreviewable') && $file->isPreviewable())
				<span class="text-xs">Pré-visualização:</span>
				<img src="{{ $file->temporaryUrl() }}" alt="{{ $input->getTitle() }}" class="h-8 ">	 
			@endif

			@if(method_exists($file, 'getClientOriginalName'))
				<span class="text-xs">Arquivo selecionado:</span>
				{{ $file->getClientOriginalName() }} 
			@endif

			@if(is_string($file))

				@php
					$exists = Storage::disk(env('FILESYSTEM_DISK', 'public'))->exists($file);

					$exp = explode('.', $file);
					$type_file = end($exp);
				@endphp

				@if($exists)
					@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
						<img src="{{ Storage::disk(env('FILESYSTEM_DISK', 'public'))->url($file) }}" alt="{{ $input->getTitle() }}" class="h-8">
					@else
						<div class="h-8 items-center flex">
							<a href="{{ Storage::disk(env('FILESYSTEM_DISK', 'public'))->url($file) }}" class="font-medium hover:underline" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
						</div>
					@endif
				@else
					<span class="text-sm">Arquivo salvo: <br> <span class="font-medium">{{ $file }}</span></span>
				@endif
			@endif
		@endif
	</div>
</div>



