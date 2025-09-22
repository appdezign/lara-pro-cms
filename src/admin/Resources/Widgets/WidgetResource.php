<?php

namespace Lara\Admin\Resources\Widgets;

use BackedEnum;
use Lara\Admin\Resources\Base\BaseResource;
use Lara\Common\Models\LaraWidget;

class WidgetResource extends BaseResource
{

	protected static ?string $model = LaraWidget::class;

	protected static bool $shouldRegisterNavigation = true;

	protected static ?int $navigationSort = 10;

	protected static string|BackedEnum|null $navigationIcon = null;

	public static function getModule(): string
	{
		return 'lara-admin';
	}

	public static function getPages(): array
	{
		return [
			'index'   => Pages\ListRecords::route('/'),
			'create'  => Pages\CreateRecord::route('/create'),
			'reorder' => Pages\ReorderRecords::route('/reorder'),
			'view'    => Pages\ViewRecord::route('/{record}'),
			'edit'    => Pages\EditRecord::route('/{record}/edit'),
		];
	}

}
