<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum MenuItemTarget: string implements HasLabel
{
    case Self = '_self';
    case Blank = '_blank';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Self => _q('lara-admin::menu-items.target._self'),
            self::Blank => _q('lara-admin::menu-items.target._blank'),
        };
    }
}
