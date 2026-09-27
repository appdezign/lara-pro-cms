<?php

namespace Lara\Admin\Resources\MenuItems\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Lara\Admin\Concerns\HasFilters;
use Lara\Admin\Concerns\HasLocks;
use Lara\Admin\Concerns\HasReorder;
use Lara\Admin\Resources\MenuItems\MenuItemResource;
use Lara\Common\Models\Menu;

class ListMenuItems extends ListRecords
{
    use HasFilters;
    use HasLocks;
    use HasReorder;

    protected static string $resource = MenuItemResource::class;

    public function mount(): void
    {
        parent::mount();
        static::unlockAbandonedObjects();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reorder')
                ->action(fn () => redirect()->route('filament.admin.resources.menus.reorder', ['record' => static::getActiveMenuFilter()]))
                ->icon('bi-arrows-move')
                ->iconButton()
                ->visible(static::getActiveMenuFilter()),
            CreateAction::make()
                ->icon('bi-plus-lg')
                ->iconButton(),
            Action::make('positions')
                ->label(_q('lara-admin::menu-reorder.button.positions'))
                ->action(fn () => redirect()->route('filament.admin.resources.menus.index')),
        ];
    }

    protected static function getActiveMenuFilter(): ?int
    {
        $menuFilter = static::getActiveFilterFromPage(self::class, 'menu_id');
        if (empty($menuFilter)) {
            $menuFilter = Menu::where('slug', 'main')->first()->value('id');
        }

        return $menuFilter;
    }

    public function render(): View
    {
        return view($this->getView(), $this->getViewData())
            ->layout('lara-admin::layout.menu-item-list', [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);

        return view();
    }
}
