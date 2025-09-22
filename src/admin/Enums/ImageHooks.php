<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum ImageHooks: string implements HasLabel
{
	case FEATURED = 'featured';
	case THUMB = 'thumb';
	case HERO = 'hero';
	case ICON = 'icon';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::FEATURED => 'Featured',
			self::THUMB => 'Thumbnail',
			self::HERO => 'Hero',
			self::ICON => 'Icon',
		};
	}

	public function getEntityField(): ?string
	{
		return match ($this) {
			self::FEATURED => 'media_has_featured',
			self::THUMB => 'media_has_thumb',
			self::HERO => 'media_has_hero',
			self::ICON => 'media_has_icon',
		};
	}

}
