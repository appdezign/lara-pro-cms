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
			'index'   => Pages\ListWidgets::route('/'),
			'create'  => Pages\CreateWidget::route('/create'),
			'reorder' => Pages\ReorderWidgets::route('/reorder'),
			'view'    => Pages\ViewWidget::route('/{record}'),
			'edit'    => Pages\EditWidget::route('/{record}/edit'),
		];
	}

}
