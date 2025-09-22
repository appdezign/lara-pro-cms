<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityViewListTypes: string implements HasLabel
{

	case List = 'list';
	case Grid2 = 'grid2';
	case Grid3 = 'grid3';
	case Grid4 = 'grid4';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::List => 'List',
			self::Grid2 => 'Grid 2',
			self::Grid3 => 'Grid 3',
			self::Grid4 => 'Grid 4',
		};
	}

}
