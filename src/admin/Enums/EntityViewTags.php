<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityViewTags: string implements HasLabel
{
	case Filterbytaxonomy = 'filterbytaxonomy';
	case Sortbytaxonomy = '_sortbytaxonomy';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Filterbytaxonomy => 'filter by tag',
			self::Sortbytaxonomy => 'sort by tag',
		};
	}

}
