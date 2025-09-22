<?php

namespace Lara\Admin\Pages\Lara;

use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class LaraReorderRecords extends Page
{

	protected string $view = 'lara-admin::pages.entity-reorder';

	public function getTitle(): string
	{
		return static::getResource()::getTitleCasePluralModelLabel();
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('backtoindex')
				->url(static::getResource()::getUrl())->button()
				->icon('heroicon-o-chevron-left')
				->iconButton()
				->color('gray'),
		];
	}

	public function render(): View
	{

		abort_unless(static::$resource::resourceIsSortable(), 403);

		return view($this->getView(), ['resourceSlug', static::getSlug()])
			->layout('lara-admin::layout.focus-mode', [
				'livewire' => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}


}
