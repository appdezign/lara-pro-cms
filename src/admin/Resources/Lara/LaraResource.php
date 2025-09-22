<?php

namespace Lara\Admin\Resources\Lara;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class LaraResource extends Resource
{

	// Use Spatie Roles and Permissions for access
	public static function canViewAny(): bool
	{
		return auth()->user()->can('view_any_' . static::getModelLabel());
	}

	public static function canView(Model $record): bool
	{
		return auth()->user()->can('view_' . static::getModelLabel());
	}

	public static function canCreate(): bool
	{
		return auth()->user()->can('create_' . static::getModelLabel());
	}

	public static function canEdit(Model $record): bool
	{
		return auth()->user()->can('update_' . static::getModelLabel());
	}

	public static function canDelete(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getModelLabel());
	}

	public static function canReorder(): bool
	{
		return auth()->user()->can('update_' . static::getModelLabel());
	}

	public static function canReplicate(Model $record): bool
	{
		return auth()->user()->can('update_' . static::getModelLabel());
	}

	public static function canForceDelete(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getModelLabel());
	}

	public static function canForceDeleteAny(): bool
	{
		return auth()->user()->can('delete_' . static::getModelLabel());
	}

	public static function canRestore(Model $record): bool
	{
		return auth()->user()->can('delete_' . static::getModelLabel());
	}

	public static function canRestoreAny(): bool
	{
		return auth()->user()->can('delete_' . static::getModelLabel());
	}
}
