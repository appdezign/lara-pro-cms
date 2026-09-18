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
			'index'   => Pages\ListSliders::route('/'),
			'create'  => Pages\CreateSlider::route('/create'),
			'reorder' => Pages\ReorderSliders::route('/reorder'),
			'view'    => Pages\ViewSlider::route('/{record}'),
			'edit'    => Pages\EditSlider::route('/{record}/edit'),
		];
	}

}
