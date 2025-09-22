<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum LaraPermissions: string implements HasLabel
{


	case ViewAny = 'view_any';
	case View = 'view';
	case Create = 'create';
	case Update = 'update';
	case Delete = 'delete';
	case DeleteAny = 'delete_any';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::ViewAny => 'View any',
			self::View => 'View',
			self::Create => 'Create',
			self::Update => 'Update',
			self::Delete => 'Delete',
			self::DeleteAny => 'Delete_any',
		};
	}

}
