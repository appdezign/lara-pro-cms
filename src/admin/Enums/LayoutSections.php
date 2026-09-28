<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum LayoutSections: string implements HasLabel
{
    case Header = 'header';
    case Hero = 'hero';
    case PageTitle = 'pagetitle';
    case Content = 'content';
    case Share = 'share';
    case Cta = 'cta';
    case Footer = 'footer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Header => 'header',
            self::Hero => 'hero',
            self::PageTitle => 'pagetitle',
            self::Content => 'content',
            self::Share => 'share',
            self::Cta => 'cta',
            self::Footer => 'footer',
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
