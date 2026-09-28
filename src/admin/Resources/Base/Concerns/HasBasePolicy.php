<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasBasePolicy
{
    /**
     * The model part of the permission names, e.g. "larawidget" in "view_any_larawidget".
     *
     * Derived from the model class, the same way the Role screen names the permissions it grants
     * (RoleForm::getPoliciesFromGate) and the policies check them. It used to come from the resource
     * slug, which gave "widget" for WidgetResource: permissions no role could be given.
     */
    private static function getPermissionModelName(): string
    {
        return strtolower(class_basename(static::getModel()));
    }

    // Use Spatie Roles and Permissions for access
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_any_'.static::getPermissionModelName());
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can('view_'.static::getPermissionModelName());
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_'.static::getPermissionModelName());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('update_'.static::getPermissionModelName());
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete_'.static::getPermissionModelName());
    }

    public static function canReorder(): bool
    {
        return auth()->user()->can('update_'.static::getPermissionModelName());
    }

    public static function canReplicate(Model $record): bool
    {
        return auth()->user()->can('update_'.static::getPermissionModelName());
    }

    public static function canForceDelete(Model $record): bool
    {
        return auth()->user()->can('delete_'.static::getPermissionModelName());
    }

    public static function canForceDeleteAny(): bool
    {
        return auth()->user()->can('delete_'.static::getPermissionModelName());
    }

    public static function canRestore(Model $record): bool
    {
        return auth()->user()->can('delete_'.static::getPermissionModelName());
    }

    public static function canRestoreAny(): bool
    {
        return auth()->user()->can('delete_'.static::getPermissionModelName());
    }
}
