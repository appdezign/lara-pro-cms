<?php

namespace Lara\Admin\Resources\Menus\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

use Lara\Admin\Resources\MenuItems\MenuItemResource;
use Lara\Admin\Resources\Menus\MenuResource;

class MenuReorder extends Page
{
    use InteractsWithRecord;

    protected static string $resource = MenuResource::class;

    protected string $view = 'lara-admin::pages.menu-reorder';

    public function getTitle(): string | Htmlable
    {
        return _q('lara-admin::menu-reorder.page.title');
    }

	public static function shouldRegisterNavigation(array $parameters = []): bool
	{
		return false;
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('done')
				->label(_q('lara-admin::default.button.done'))
				->action(function () {
					return redirect(MenuItemResource::getUrl());
				}),
		];
	}

	public function mount($record): void
    {

        $this->record = $this->resolveRecord($record);

        $this->heading = $this->getTitle();
    }


}
