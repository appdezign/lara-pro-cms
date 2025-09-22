<x-filament-panels::page>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 xl:col-span-10 xl:col-start-2">
	        @livewire('lara-entity-reorder', ['resourceSlug' => $this->getResource()::getSlug()])
        </div>
    </div>
</x-filament-panels::page>
