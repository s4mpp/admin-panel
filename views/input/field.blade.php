<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 md:grid md:grid-cols-12">
	<div class="text-sm font-medium text-slate-900  md:col-span-3 lg:col-span-2 xl:h-9 flex flex-col justify-center mb-2 md:mb-0" >
		<span class="">
			{{ $input->getTitle() }}

			@if($input->isRequired())
				<span class="text-red-300 text-xs truncate">*</span>
			@endif
		</span>

		@if($description = $input->getDescription())
			<span class="text-xs text-gray-400">{{ $description }}</span>
		@endif
		
	</div>
	<div class="text-sm font-normal text-slate-700 md:col-span-9 lg:col-span-10 ">
		{{ $input->renderInput($data, $register) }}
	</div>
</div>