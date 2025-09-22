<x-dynamic-component
	:component="$getFieldWrapperView()"
	:field="$field"
>
	<div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">

		<div
			class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white [&amp;:not(:has(.fi-ac-action:focus))]:focus-within:ring-2 ring-gray-950/10 [&amp;:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600 fi-fo-text-input overflow-hidden">
			<div class="fi-input-wrp-input min-w-0 flex-1">
				<input
					type="text"
					x-model="state"
					class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
				/>
			</div>
		</div>

	</div>

	@if($getState() && strlen($getState()) == 11)
		<div class="video-preview ratio ratio-16x9">
			<iframe width="560" height="315"
			        src="https://www.youtube.com/embed/{{ $getState() }}?rel=0"
			        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
	@endif

</x-dynamic-component>
