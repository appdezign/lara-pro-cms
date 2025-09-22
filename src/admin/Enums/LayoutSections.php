<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum LayoutSections: string implements HasLabel
{
	case HEADER = 'header';
	case HERO = 'hero';
	case PAGETITLE = 'pagetitle';
	case CONTENT = 'content';
	case SHARE = 'share';
	case CTA = 'cta';
	case FOOTER = 'footer';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::HEADER => 'header',
			self::HERO => 'hero',
			self::PAGETITLE => 'pagetitle',
			self::CONTENT => 'content',
			self::SHARE => 'share',
			self::CTA => 'cta',
			self::FOOTER => 'footer',
		};
	}

	public static function toArray(): array
	{
		$array = [];
		foreach (self::cases() as $case) {
			$array[] = $case->value;
		}

		return $array;
	}

}
