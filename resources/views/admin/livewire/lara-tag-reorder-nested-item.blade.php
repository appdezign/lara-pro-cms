<div class="item lara-reorder-menu-item handle cursor-pointer" data-id="{{ $item->id }}"
     wire:key="{{'tag-item-'.$item->id}}">
	<div @class([
        'flex justify-between mb-2 content-center rounded bg-white border border-gray-300 shadow-sm pr-2 dark:bg-gray-900 dark:border-gray-800' => true
])>
		<div class="flex content-center items-center">
			<div class="border-r-2 border-gray-300 text-gray-400">
				<x-bi-grip-vertical class="w-4 h-4 m-2 "/>
			</div>
			<div class="ml-2 flex">
				<span class="font-normal text-sm">{{ $item->title }}</span>
			</div>
		</div>
	</div>

	<div
		@class(['nested ml-6' => true])
		data-id="{{ $item->id }}"
		x-data="{
            init(){
                new Sortable(this.$el, {
                    handle: '.handle',
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onEnd: (evt) => {
                        this.data = getDataStructure(document.getElementById('parentNested'));
                    }
                })
            },
        }"
	>
		@foreach($item->children as $children)
			@include('lara-admin::livewire.lara-tag-reorder-nested-item', ['item' => $children])
		@endforeach
	</div>
</div>
