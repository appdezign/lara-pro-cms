<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityHook: string implements HasLabel
{
	case BeforeTitle = 'before-title';
	case AfterTitle = 'after-title';
	case AfterSlug = 'after-slug';
	case AfterLast = 'after-last';
	case Default = 'default';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::BeforeTitle => 'Before Title',
			self::AfterTitle => 'After Title',
			self::AfterSlug => 'After Slug',
			self::AfterLast => 'After Last',
			self::Default => 'Default',
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
