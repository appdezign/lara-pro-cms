<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum MenuItemType: string implements HasLabel
{
	case Page = 'page';
	case Parent = 'parent';
	case Entity = 'entity';
	case Form = 'form';
	case Url = 'url';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Page => 'Page',
			self::Parent => 'Folder',
			self::Entity => 'Module',
			self::Form => 'Form',
			self::Url => 'URL',
		};
	}

}
