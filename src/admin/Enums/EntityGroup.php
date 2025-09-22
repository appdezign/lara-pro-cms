<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityGroup: string implements HasLabel
{
	case Page = 'page';
	case Block = 'block';
	case Entity = 'entity';
	case Taxonomy = 'taxonomy';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Page => 'Page',
			self::Block => 'Block',
			self::Entity => 'Entity',
			self::Taxonomy => 'Taxonomy',
		};
	}

	public static function toArray(): array
	{
		$array = [];
		foreach (self::cases() as $case) {
			$array[$case->value] = $case->value;
		}
		return $array;
	}

}
