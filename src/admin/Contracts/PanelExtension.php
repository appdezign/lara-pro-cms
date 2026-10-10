<?php

namespace Lara\Admin\Contracts;

use Closure;
use Filament\Navigation\NavigationItem;

/**
 * Adds navigation items and authenticated routes to the admin panel.
 *
 * Extensions are listed in config('lara-admin.panel_extensions'), so core does not have to know the
 * site's classes. The legacy (non-Livewire) admin pages of a site are registered this way.
 */
interface PanelExtension
{
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
