<?php

namespace Lara\Admin\Resources\Sliders;

use Lara\Admin\Resources\Base\BaseResource;
use Lara\Common\Models\Slider;

class SliderResource extends BaseResource
{
	protected static ?string $model = Slider::class;

	protected static bool $shouldRegisterNavigation = true;

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
