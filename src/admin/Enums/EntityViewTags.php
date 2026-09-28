<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityViewTags: string implements HasLabel
{
    case FilterByTaxonomy = 'filterbytaxonomy';
    case SortByTaxonomy = '_sortbytaxonomy';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FilterByTaxonomy => 'filter by tag',
            self::SortByTaxonomy => 'sort by tag',
        };
    }
}
