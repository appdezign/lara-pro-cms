<?php

namespace Lara\Common\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Invalidates the cached entity configuration whenever it changes.
 *
 * Attached via #[ObservedBy] to Entity and to the three tables that make up an
 * entity's configuration: custom fields, views and relations. Without this the
 * rememberForever caches were never invalidated at all, so a configuration
 * change only took effect after the whole application cache was wiped.
 */
class EntityConfigObserver
{
    public function saved(Model $model): void
    {
        $this->flush();
    }

    public function deleted(Model $model): void
    {
        $this->flush();
    }

    public function restored(Model $model): void
    {
        $this->flush();
    }

    public function forceDeleted(Model $model): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        app(EntityRegistry::class)->flush();
    }
}
