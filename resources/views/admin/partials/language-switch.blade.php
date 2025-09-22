@php
	$languages = \Lara\Common\Models\Language::pluck('code', 'code');
	$current = session('_lara_global.clanguage');
	$currentRoutename = Route::currentRouteName();
	$resourceIndexRoutename = getIndexRoutename($currentRoutename);
@endphp

@if($resourceIndexRoutename)
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
			id="lara-language-switch"
			x-on:click="toggle"
		>
			<div
				@class([
					'flex items-center justify-center bg-cover bg-center',
					'w-11 h-8 bg-transparent'
				])
			>
				{{ $current }}

			</div>
		</button>

		<div x-ref="panel" x-float.placement.bottom-end.flip.offset="{ offset: 8 }"
		     x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95"
		     class="fi-dropdown-panel absolute z-10 shadow-lg transition max-w-[14rem]"
		     style="display: none;">
			<div class="filament-dropdown-list p-1">
				@foreach ($languages as $lang)
					<a
						@class([
							'fi-dropdown-list-item fi-dropdown-list-item-lang-switch filament-dropdown-item group flex items-center whitespace-nowrap px-4 py-2 text-sm outline-none',
						])
						href="{{ route( $resourceIndexRoutename, ['clanguage' => $lang] ) }}"
					>
                    <span
	                    class="fi-dropdown-list-item-label truncate text-start flex gap-3">
                        <span>{{ $lang }}</span>
                    </span>
					</a>
				@endforeach
			</div>
		</div>
	</div>
@else
	@if($current)
		<button class="block" id="lara-language-switch" disabled>
			<div
				@class([
					'flex items-center justify-center bg-cover bg-center',
					'w-11 h-8 bg-transparent'
				])
			>
				{{ $current }}

			</div>
		</button>
	@endif
@endif
