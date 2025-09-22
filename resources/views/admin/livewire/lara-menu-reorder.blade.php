<div>
	<section class="flex flex-col gap-y-8 px-8 py-8 bg-white border border-gray-200 ">

		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 lg:col-span-10 lg:col-start-2 xl:col-span-8 xl:col-start-3 ">

				<form wire:submit="save" x-data="{
				        data: $wire.entangle('data'),
				        sortables: [],
				        getDataStructure(parentNode) {
				          const items = Array.from(parentNode.children).filter((item) => {
				            return item.classList.contains('item');
				          }); // Get children items of the current node

				          return Array.from(items).map((item) => {
				            const id = item.getAttribute('data-id');
				            const nestedContainer = item.querySelector('.nested');
				            const children = nestedContainer ? this.getDataStructure(nestedContainer): [];

				            return { id: parseInt(id), children };
				          });
				        }
				    }"
				>
					@if($items->count() > 0)
						<div class="nested-wrapper">
							<div id="parentNested" class="nested"
							     x-data="{
				                    init(){
				                        new Sortable(this.$el, {
				                            handle: '.handle',
				                            group: 'nested',
				                            animation: 150,
				                            fallbackOnBody: true,
				                            swapThreshold: 0.65,
				                            filter: '.no-drag',
				                            onEnd: (evt) => {
				                                this.data = getDataStructure(document.getElementById('parentNested'));
				                            }
				                        })
				                    },
				                }">
								@foreach($items as $item)
									@include('lara-admin::livewire.lara-menu-reorder-item', ['item' => $item])
								@endforeach
							</div>
						</div>
						<x-filament::button
							:dark-mode="config('filament.dark_mode')"
							wire:loading.attr="disabled"
							type="submit"
							class="mt-2"
						>
							<x-filament::loading-indicator wire:loading class="h-5 w-5"/>
							{{ __('Save') }}
						</x-filament::button>

						<x-filament::button
							:dark-mode="config('filament.dark_mode')"
							wire:loading.attr="disabled"
							type="button"
							class="mt-2"
							color="danger"
							wire:click="$refresh"
						>
							<x-filament::loading-indicator wire:loading class="h-5 w-5"/>
							{{ __('Reset') }}
						</x-filament::button>
						<p class="text-gray-500 text-center mt-2 text-[13px]">
							{{ _q('lara-admin::menu-reorder.message.menu_save_information') }}
						</p>
					@else
						<div class="text-gray-500 text-center">
							<p>
								{{ _q('lara-admin::menu-reorder.message.empty_menu_items_hint_1') }}
							</p>
							<p>
								{{ _q('lara-admin::menu-reorder.message.empty_menu_items_hint_2') }}
							</p>
						</div>
					@endif
				</form>
			</div>
		</div>

	</section>
</div>
