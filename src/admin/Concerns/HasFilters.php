<?php

namespace Lara\Admin\Concerns;

trait HasFilters
{
    /**
     * Read a persisted table filter value of a list page from the session.
     *
     * Mirrors the session key of Filament's `getTableFiltersSessionKey()`
     * (no tenancy, no table identifier).
     */
    private static function getActiveFilterFromPage(string $pageClass, string $filterName, ?string $defaultValue = null): ?string
    {
        $sessionKey = 'filament.tables.'.hash('sha256', $pageClass).'.filters';

        $value = data_get(session()->get($sessionKey), "{$filterName}.value");

        return filled($value) ? (string) $value : $defaultValue;
    }
}
