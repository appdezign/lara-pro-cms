<?php

namespace Lara\Common\Console;

use Illuminate\Console\Command;
use Lara\Common\Models\MenuItem;
use Lara\Common\Routes\MenuRouteName;

/**
 * Recompute the route name every menu item records.
 *
 * The admin menu builder names routes when a menu is saved. Menus saved before the naming
 * changed (see MenuRouteName) still record the old names, which contained the menu item ID;
 * this brings them in line without having to re-save every menu by hand.
 */
class RefreshMenuRouteNamesCommand extends Command
{
    protected $signature = 'lara:menu:refresh-routenames {--dry-run : Only show what would change}';

    protected $description = 'Recompute the route names recorded on the menu items';

    public function handle(): int
    {
        $changes = [];

        foreach (MenuItem::with(['entity', 'entityview'])->get() as $menuItem) {
            $routeName = MenuRouteName::forMenuItem($menuItem, $menuItem->entity, $menuItem->entityview);

            if ($routeName === $menuItem->routename) {
                continue;
            }

            $changes[] = [$menuItem->id, $menuItem->language, $menuItem->title, $menuItem->routename ?? '-', $routeName ?? '-'];

            if (! $this->option('dry-run')) {
                $menuItem->routename = $routeName;
                $menuItem->saveQuietly();
            }
        }

        if ($changes === []) {
            $this->info('All menu items already record the right route name.');

            return self::SUCCESS;
        }

        $this->table(['id', 'language', 'title', 'old route name', 'new route name'], $changes);

        if ($this->option('dry-run')) {
            $this->warn(count($changes).' menu items would change. Run without --dry-run to save them.');
        } else {
            $this->info(count($changes).' menu items updated. Rebuild the route cache with lara:route:cache.');
        }

        return self::SUCCESS;
    }
}
