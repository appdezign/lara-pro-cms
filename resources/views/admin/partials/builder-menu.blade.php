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

				<x-bi-stack class="h-4 w-4" />

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
