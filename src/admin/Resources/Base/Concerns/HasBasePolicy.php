<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasBasePolicy
{
	// Use Spatie Roles and Permissions for access
	public static function canViewAny(): bool
	{
		return auth()->user()->can('view_any_' . static::getSingleSlug());
	}

	public static function canView(Model $record): bool
	{
		return auth()->user()->can('view_' . static::getSingleSlug());
	}

	public static function canCreate(): bool
	{
		return auth()->user()->can('create_' . static::getSingleSlug());
	}

	public static function canEdit(Model $record): bool
	{
		return auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canDelete(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canReorder(): bool
	{
		return auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canReplicate(Model $record): bool
	{
		return auth()->user()->can('update_' . static::getSingleSlug());
	}

	public static function canForceDelete(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canForceDeleteAny(): bool
	{
		return auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canRestore(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getSingleSlug());
	}

	public static function canRestoreAny(): bool
	{
		return auth()->user()->can('delete_' . static::getSingleSlug());
	}
}