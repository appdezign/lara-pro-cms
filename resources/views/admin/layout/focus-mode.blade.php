@php
	use Filament\Support\Enums\Width;

	$livewire ??= null;

	$renderHookScopes = $livewire?->getRenderHookScopes();
	$maxContentWidth ??= (filament()->getMaxContentWidth() ?? Width::SevenExtraLarge);

	if (is_string($maxContentWidth)) {
		$maxContentWidth = Width::tryFrom($maxContentWidth) ?? $maxContentWidth;
	}
@endphp

<x-filament-panels::layout.base
	:livewire="$livewire"
>


	<div class="fi-layout">
		{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::LAYOUT_START, scopes: $renderHookScopes) }}

		<div
			x-data="{}"
			x-bind:style="'display: flex; opacity:1;'"
			class="fi-main-ctn"
		>
			<main
				@class([
					'fi-main lara-focus-mode',
					($maxContentWidth instanceof Width) ? "fi-width-{$maxContentWidth->value}" : $maxContentWidth,
				])
			>
				{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_START, scopes: $renderHookScopes) }}

				{{ $slot }}

				{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_END, scopes: $renderHookScopes) }}
			</main>

			{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $renderHookScopes) }}
		</div>

		{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::LAYOUT_END, scopes: $renderHookScopes) }}
	</div>
</x-filament-panels::layout.base>
