<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;

trait HasTableActions
{
	private static function getBaseTableActions(): array
	{

		$actions = array();

		if (static::showViewAction()) {
			$actions[] = ViewAction::make()
				->label('');
		}
		if (static::showEditAction()) {
			$actions[] = EditAction::make()
				->label('')
				->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-pencil-square')
				->disabled(fn($record) => $record->isLocked());
		}
		if (static::showDeleteAction()) {
			$actions[] = DeleteAction::make()
				->label('')
				->tableIcon(fn($record) => $record->isLocked() ? 'bi-lock' : 'bi-trash3')
				->disabled(fn($record) => $record->isLocked());
		}
		if (static::showRestoreAction()) {
			$actions[] = RestoreAction::make()
				->label('')
				->disabled(fn($record) => $record->isLocked());
		}

		return $actions;
	}

	private static function getBaseTableBulkActions(): array
	{
		$actions = array();
		if (static::resourceShowBatch()) {
			$actions[] = BulkActionGroup::make([
				DeleteBulkAction::make(),
				ForceDeleteBulkAction::make(),
				RestoreBulkAction::make(),
			]);
		}

		return $actions;
	}

}