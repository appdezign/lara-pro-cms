<div style="background-color: #fff; padding: 2rem; border: solid 1px #dce1e6; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
	<form wire:submit="clear">
		{{ $this->form }}

		<x-filament::button
				type="submit"
				color="primary"
				class="mt-8"
		>
			{{ _q('lara-admin::cache.button.clear_cache', true) }}
		</x-filament::button>
	</form>

	<x-filament-actions::modals />
</div>

