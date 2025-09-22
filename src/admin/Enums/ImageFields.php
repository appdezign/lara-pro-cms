<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum ImageFields: string implements HasLabel
{
	case FILENAME = 'filename';
	case ORIGINAL = 'original';
	case SEO_ALT = 'seo_alt';
	case SEO_TITLE = 'seo_title';
	case CAPTION = 'caption';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::FILENAME => 'Filename',
			self::ORIGINAL => 'Original',
			self::SEO_ALT => 'SEO alt',
			self::SEO_TITLE => 'SEO title',
			self::CAPTION => 'Caption',
		};
	}

}
