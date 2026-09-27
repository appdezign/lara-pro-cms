<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum ImageHooks: string implements HasLabel
{
    case Featured = 'featured';
    case Thumb = 'thumb';
    case Hero = 'hero';
    case Icon = 'icon';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Featured => 'Featured',
            self::Thumb => 'Thumbnail',
            self::Hero => 'Hero',
            self::Icon => 'Icon',
        };
    }

    public function getEntityField(): ?string
    {
        return match ($this) {
            self::Featured => 'media_has_featured',
            self::Thumb => 'media_has_thumb',
            self::Hero => 'media_has_hero',
            self::Icon => 'media_has_icon',
        };
    }
}
