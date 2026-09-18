<?php

namespace Lara\Admin\Resources\Ctas;

use Lara\Admin\Resources\Base\BaseResource;
use Lara\Common\Models\Cta;

class CtaResource extends BaseResource
{
	protected static ?string $model = Cta::class;

	protected static bool $shouldRegisterNavigation = true;

	public static function getPages(): array
	{
		return [
			'index'   => Pages\ListCtas::route('/'),
			'create'  => Pages\CreateCta::route('/create'),
			'reorder' => Pages\ReorderCtas::route('/reorder'),
			'view'    => Pages\ViewCta::route('/{record}'),
			'edit'    => Pages\EditCta::route('/{record}/edit'),
		];
	}

}
