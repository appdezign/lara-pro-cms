<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Lara\Admin\Enums\MenuItemType;
use Lara\Common\Database\Factories\PageFactory;
use LogicException;

class Page extends BaseModel
{
    protected $table = 'lara_content_pages';

    protected static function booted(): void
    {
        // a menu item linking to a trashed page breaks the pages list and the menu route
        static::deleting(function (Page $page): void {
            if ($page->isInMenu()) {
                throw new LogicException("Page [{$page->id}] is in the menu and cannot be deleted. Delete its menu item first.");
            }
        });
    }

    protected static function newFactory()
    {
        return PageFactory::new();
    }

    /**
     * The menu items that link to this page, published or not.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'object_id')
            ->where('type', MenuItemType::Page->value);
    }

    public function isInMenu(): bool
    {
        return $this->menuItems()->exists();
    }

    public function canBeDeleted(): bool
    {
        return ! $this->isInMenu();
    }

    public function languageParent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'language_parent');
    }

    public function languageChildren(): HasMany
    {
        return $this->hasMany(self::class, 'language_parent');
    }

    /**
     * @return MorphToMany
     */
    public function widgets()
    {
        return $this->morphedByMany(LaraWidget::class, 'entity', config('lara-common.database.object.pageables'))
            ->where('is_global', 0)
            ->orderBy('hook', 'asc')
            ->orderBy('sortorder', 'asc');
    }
}
