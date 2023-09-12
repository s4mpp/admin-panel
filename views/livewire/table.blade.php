
<div class="border sm:rounded-lg bg-white"> 
    @php
        $rowspan_empty = count($table) ?? 1;
    
        if($actions)
        {
            $rowspan_empty++;
        }
    @endphp
	<div class="min-w-full px-5 py-2 flex justify-start">
		@if($has_search)
			<div class="w-full sm:w-6/12 md:w-5/12 xl:w-4/12 mr-3">
				<x-input placeholder="{{ $placeholder_field_search }}" wire:model="search"  type="search" name="search"></x-input>
			</div>
		@endif

		

		{{-- <div class="relative inline-block text-left">
			<div>
			  <x-button type="button" className="btn-light">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
				  </svg>
			  </x-button>
			</div>
		  
			<!--
			  Dropdown menu, show/hide based on menu state.
		  
			  Entering: "transition ease-out duration-100"
				From: "transform opacity-0 scale-95"
				To: "transform opacity-100 scale-100"
			  Leaving: "transition ease-in duration-75"
				From: "transform opacity-100 scale-100"
				To: "transform opacity-0 scale-95"
			-->
			<div class="absolute right-0 z-10 mt-2 w-80  origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
 				<div class="p-4">
					<div class="flex justify-between mb-5 items-center " >
						<p class="font-semibold text-gray-900">Filtros</p>
						<a href="#" class="text-red-500 text-sm font-semibold">Limpar</a>
					</div>

					<div class="divide-y divide-gray-100">
						<div class="py-4">
							<x-input type="checkbox" title="Tipo" name="type[]">
								@foreach(\App\Enums\CustomerType::cases() as $option)
								<x-check value="{{ $option->value }}">{{ $option->label() }}</x-check>
								@endforeach
							</x-input>
						</div>

						<div class="py-4">
							<x-input type="checkbox" title="Tipo" name="type[]">
								@foreach(\App\Enums\CustomerType::cases() as $option)
									<x-check value="{{ $option->value }}">{{ $option->label() }}</x-check>
								@endforeach
							</x-input>
						</div>
					</div>
				</div>
 			</div>
		  </div> --}}
	</div>
	
	<div class="overflow-x-auto ">
		<table class="min-w-full divide-y border-t divide-gray-200">
		<thead class="bg-gray-100 rounded">
		  <tr>
			  @forelse($table as $column)
				  <th scope="col" @class(array_merge($column->style_class, ['px-5 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap']))>{{ $column->title }}</th>
			  @empty
				  <th scope="col" class="px-3 py-3.5">&nbsp;</th>
			  @endforelse

			  @if($actions)
				<th></th>
			@endif
		  </tr>
		</thead>
		<tbody class="divide-y divide-gray-200 bg-white">
			@if($registers)
				@foreach($registers as $id => $row)
					<tr>
						@forelse ($row as $field)
							<td @class(array_merge($field->style_class, ['whitespace-nowrap px-5 py-4 text-sm text-gray-500']))>
								@php
									$data = $field->data;
								@endphp
								@switch($field->type)
									@case('boolean')
										
										@if($data)
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-green-500">
											<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
										</svg>
										@else
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-red-500">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
											</svg>
										@endif
										@break
									
									@case('enum')
										<x-badge :provider=$data></x-badge>
										@break
									
									@case('dump')
										@dump($data)
										@break

									@default
										{{ $data }}
								@endswitch
							</td>
						@empty
							<td>&nbsp;</td>
						@endforelse 

						@if($actions)
							<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
							   <div class="inline-flex gap-3">
								   @foreach($actions as $action)

								   		{{-- TO-DO: colocar no metodo getRoutes --}}
									   @if(!in_array('table', $action->show_in))
										   @continue
									   @endif
						   
									   @if($action->method == 'GET')
										   @php
											   $link = route($routes[$action->route], ['id' => $id]);
										   @endphp
						   
											<a
											@if($action->new_tab)
												target="_blank"
											@endif
											 href="{{ $link }}" class="{{ $action->is_danger ?  'text-red-500 hover:text-red-600' : 'text-gray-500 hover:text-gray-600' }} inline-flex gap-1">
												<span>{{ $action->title }}</span>
											</a>
									   @else
										   <form 
										   @if($action->new_tab)
												target="_blank"
											@endif
											@isset($action->question)
												onsubmit="return window.confirm('{{ $action->question }}')"
											@endisset
											method="POST"  action="{{ route($routes[$action->route], ['id' => $id]) }}">
											   @method(strtoupper($action->method))
											   @csrf
											   
												<button class="{{ $action->is_danger ?  'text-red-500 hover:text-red-600' : null }} inline-flex gap-1" type="submit">{{ $action->title }}</button>
										   </form>
									   @endif
								   @endforeach
							   </div>
							</td>
						@endif
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="{{ $rowspan_empty }}" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
						
						<span  class="text-sm mt-3 ">{{ $this->search ? 'Nada encontrado' : 'Nenhum registro' }}</span>
					</td>
				</tr>
			@endif
        </tbody>
	  </table>
	</div>

	@if($collection)
		<div class="min-w-full px-3  p-5">
			{{ $collection->links('admin::pagination') }}
		</div>
	@endif
</div>