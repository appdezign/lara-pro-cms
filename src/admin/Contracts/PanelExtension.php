<?php

namespace Lara\Admin\Contracts;

use Closure;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

/**
 * Adds navigation groups, navigation items and authenticated routes to the admin panel.
 *
 * Extensions are listed in config('lara-admin.panel_extensions'), so core does not have to know the
 * site's classes. The legacy (non-Livewire) admin pages of a site are registered this way.
 */
interface PanelExtension
{
    /**
     * Navigation groups of the extension's items, listed after the core groups.
     *
     * @return array<NavigationGroup>
     */
    public function navigationGroups(): array;

    /**
     * @return array<NavigationItem>
     */
    public function navigationItems(): array;

    /**
     * Routes registered inside the panel, with its middleware and auth middleware,
     * under the panel path and the route name prefix `filament.admin.`.
     */
    public function routes(): ?Closure;
}
