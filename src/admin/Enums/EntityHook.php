<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityHook: string implements HasLabel
{
	case BEFORE_TITLE = 'before-title';
	case AFTER_TITLE = 'after-title';
	case AFTER_SLUG = 'after-slug';
	case AFTER_LAST = 'after-last';
	case DEFAULT = 'default';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::BEFORE_TITLE => 'Before Title',
			self::AFTER_TITLE => 'After Title',
			self::AFTER_SLUG => 'After Slug',
			self::AFTER_LAST => 'After Last',
			self::DEFAULT => 'Default',
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
