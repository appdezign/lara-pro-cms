<?php

namespace Lara\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lara\Common\Models\User;
use Lara\Common\Models\LaraWidget;

class WidgetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_widget');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LaraWidget $widget): bool
    {
        return $user->can('view_widget');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_widget');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LaraWidget $widget): bool
    {
        return $user->can('update_widget');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LaraWidget $widget): bool
    {
        return $user->can('delete_widget');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_widget');
    }
}
