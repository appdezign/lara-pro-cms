<?php

namespace Lara\Admin\Resources\Pages;

use BackedEnum;
use Lara\Admin\Resources\Base\BaseResource;
use Lara\Common\Models\Page;

class PageResource extends BaseResource
{

	protected static ?string $model = Page::class;


	protected static bool $shouldRegisterNavigation = true;

	protected static ?int $navigationSort = 10;

	protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

	public static function getModule(): string
	{
		return 'lara-admin';
	}

	public static function getPages(): array
	{
		return [
			'index'  => Pages\ListPages::route('/'),
			'create' => Pages\CreatePage::route('/create'),
			'view'   => Pages\ViewPage::route('/{record}'),
			'edit'   => Pages\EditPage::route('/{record}/edit'),
		];
	}

}
