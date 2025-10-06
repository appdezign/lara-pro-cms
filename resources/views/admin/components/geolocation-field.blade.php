@php
	$fieldWrapperView = $getFieldWrapperView();
	$extraInputAttributeBag = $getExtraInputAttributeBag();
	$canSelectPlaceholder = $canSelectPlaceholder();
	$isAutofocused = $isAutofocused();
	$isDisabled = $isDisabled();
	$isMultiple = $isMultiple();
	$isSearchable = $isSearchable();
	$canOptionLabelsWrap = $canOptionLabelsWrap();
	$isRequired = $isRequired();
	$isConcealed = $isConcealed();
	$isHtmlAllowed = $isHtmlAllowed();
	$isNative = (! ($isSearchable || $isMultiple) && $isNative());
	$isPrefixInline = $isPrefixInline();
	$isSuffixInline = $isSuffixInline();
	$key = $getKey();
	$id = $getId();
	$prefixActions = $getPrefixActions();
	$prefixIcon = $getPrefixIcon();
	$prefixIconColor = $getPrefixIconColor();
	$prefixLabel = $getPrefixLabel();
	$suffixActions = $getSuffixActions();
	$suffixIcon = $getSuffixIcon();
	$suffixIconColor = $getSuffixIconColor();
	$suffixLabel = $getSuffixLabel();
	$statePath = $getStatePath();
	$state = $getState();
	$livewireKey = $getLivewireKey();
@endphp

<x-dynamic-component
		:component="$fieldWrapperView"
		:field="$field"
		class="fi-fo-select-wrp"
>
	<x-filament::input.wrapper
			:disabled="$isDisabled"
			:inline-prefix="$isPrefixInline"
			:inline-suffix="$isSuffixInline"
			:prefix="$prefixLabel"
			:prefix-actions="$prefixActions"
			:prefix-icon="$prefixIcon"
			:prefix-icon-color="$prefixIconColor"
			:suffix="$suffixLabel"
			:suffix-actions="$suffixActions"
			:suffix-icon="$suffixIcon"
			:suffix-icon-color="$suffixIconColor"
			:valid="! $errors->has($statePath)"
			:attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'fi-fo-select',
                    'fi-fo-select-has-inline-prefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                    'fi-fo-select-native' => $isNative,
                ])
        "
	>

		<div
				class="fi-hidden"
				x-data="{
                    isDisabled: @js($isDisabled),
                    init() {
                        const container = $el.nextElementSibling
                        container.dispatchEvent(
                            new CustomEvent('set-select-property', {
                                detail: { isDisabled: this.isDisabled },
                            }),
                        )
                    },
                }"
		></div>
		<div
				x-load
				x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('select', 'filament/forms') }}"
				x-data="selectFormComponent({
                            canOptionLabelsWrap: @js($canOptionLabelsWrap),
                            canSelectPlaceholder: @js($canSelectPlaceholder),
                            isHtmlAllowed: @js($isHtmlAllowed),
                            getOptionLabelUsing: async () => {
                                return await $wire.callSchemaComponentMethod(@js($key), 'getOptionLabel')
                            },
                            getOptionLabelsUsing: async () => {
                                return await $wire.callSchemaComponentMethod(
                                    @js($key),
                                    'getOptionLabelsForJs',
                                )
                            },
                            getOptionsUsing: async () => {
                                return await $wire.callSchemaComponentMethod(
                                    @js($key),
                                    'getOptionsForJs',
                                )
                            },
                            getSearchResultsUsing: async (search) => {
                                return await $wire.callSchemaComponentMethod(
                                    @js($key),
                                    'getSearchResultsForJs',
                                    { search },
                                )
                            },
                            initialOptionLabel: @js((blank($state) || $isMultiple) ? null : $getOptionLabel()),
                            initialOptionLabels: @js((filled($state) && $isMultiple) ? $getOptionLabelsForJs() : []),
                            initialState: @js($state),
                            isAutofocused: @js($isAutofocused),
                            isDisabled: @js($isDisabled),
                            isMultiple: @js($isMultiple),
                            isSearchable: @js($isSearchable),
                            livewireId: @js($this->getId()),
                            hasDynamicOptions: @js($hasDynamicOptions()),
                            hasDynamicSearchResults: @js($hasDynamicSearchResults()),
                            loadingMessage: @js($getLoadingMessage()),
                            maxItems: @js($getMaxItems()),
                            maxItemsMessage: @js($getMaxItemsMessage()),
                            noSearchResultsMessage: @js($getNoSearchResultsMessage()),
                            options: @js($getOptionsForJs()),
                            optionsLimit: @js($getOptionsLimit()),
                            placeholder: @js($getPlaceholder()),
                            position: @js($getPosition()),
                            searchDebounce: @js($getSearchDebounce()),
                            searchingMessage: @js($getSearchingMessage()),
                            searchPrompt: @js($getSearchPrompt()),
                            searchableOptionFields: @js($getSearchableOptionFields()),
                            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                            statePath: @js($statePath),
                        })"
				wire:ignore
				wire:key="{{ $livewireKey }}.{{
                    substr(md5(serialize([
                        $isDisabled,
                    ])), 0, 64)
                }}"
				x-on:keydown.esc="select.dropdown.isActive && $event.stopPropagation()"
				x-on:set-select-property="$event.detail.isDisabled ? select.disable() : select.enable()"
				{{
					$attributes
						->merge($getExtraAlpineAttributes(), escape: false)
						->class(['fi-select-input'])
				}}
		>
			<div x-ref="select"></div>
		</div>
	</x-filament::input.wrapper>

	@if($getState() && $getState() != 'hidden' && $record->geo_latitude && $record->geo_longitude)

		<a href="javascript:void(0)" id="map-preview" onclick="toggleMaps({{ $record->geo_latitude }}, {{ $record->geo_longitude }})" class="fi-btn fi-size-md  fi-ac-btn-action " style="width: 160px;">
			Preview Map
		</a>

		<div class="js-maps-container mt-2 hidden">
			<div id="map-canvas"
			     style="display: flex; justify-content: center; align-items: center;  height: 500px; width: 100%; color: #b4bec8; background-color: #f8fafc; border: 1px solid #c8d2e1;">
				Loading Map ...
			</div>
		</div>

	@endif

</x-dynamic-component>
