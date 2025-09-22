<?php

namespace Lara\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lara\Common\Models\Cta;
use Lara\Common\Models\User;

class CtaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_cta');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cta $cta): bool
    {
        return $user->can('view_cta');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_cta');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cta $cta): bool
    {
        return $user->can('update_cta');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cta $cta): bool
    {
        return $user->can('delete_cta');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_cta');
    }
}
