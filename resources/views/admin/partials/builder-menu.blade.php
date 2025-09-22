@if(Auth::user()->hasRole('superadmin'))
	<div x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },
        open: function (event) {
            $refs.panel.open(event)
        },
        close: function (event) {
            $refs.panel.close(event)
        },
    }">

		<button
			@class([
				'block',
			])
			id="builder-menu"
			x-on:click="toggle"
		>
			<div
				@class([
					'flex items-center justify-center bg-cover bg-center',
					'w-11 h-8 bg-transparent'
				])
			>

				<svg class="h-6 w-6"
				     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
				</svg>



			</div>
		</button>

		<div x-ref="panel" x-float.placement.bottom-end.flip.offset="{ offset: 8 }"
		     x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95"
		     class="fi-dropdown-panel absolute z-10 w-screen shadow-lg transition max-w-[10rem]"
		     style="display: none;">
			<div class="filament-dropdown-list p-1">
				<a
					@class([
                        'fi-dropdown-list-item filament-dropdown-item group flex items-center whitespace-nowrap px-4 py-2 text-sm outline-none',
					])
					href="{{ route( 'filament.admin.resources.entities.index' ) }}"
				>
                    <span
	                    class="fi-dropdown-list-item-label truncate text-start flex gap-3">
                        <span>Content Builder</span>
                    </span>
				</a>
				<a

					@class([
						'fi-dropdown-list-item filament-dropdown-item group flex items-center whitespace-nowrap px-4 py-2 text-sm outline-none',
					])
					href="{{ route( 'filament.admin.resources.forms.index' ) }}"
				>
                    <span
	                    class="fi-dropdown-list-item-label truncate text-start flex justify-content-start gap-3">
                        <span>Form Builder</span>
                    </span>
				</a>
			</div>
		</div>
	</div>
@endif
