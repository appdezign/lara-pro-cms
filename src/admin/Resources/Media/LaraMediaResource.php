<?php

namespace Lara\Admin\Resources\Media;

use Filament\Panel;
use Filament\Tables\Table;

use Awcodes\Curator\Resources\Media\MediaResource;
use Awcodes\Curator\Resources\Media\Tables\LaraMediaTable;


class LaraMediaResource extends MediaResource
{

	public static function getSlug(?Panel $panel = null): string
	{
		return 'media';
	}

	public static function table(Table $table): Table
	{

		dd('test');
		return LaraMediaTable::configure($table);
	}

}
