<?php

namespace Lara\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lara\Common\Models\Slider;
use Lara\Common\Models\User;

class SliderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_slider');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Slider $slider): bool
    {
        return $user->can('view_slider');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_slider');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Slider $slider): bool
    {
        return $user->can('update_slider');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Slider $slider): bool
    {
        return $user->can('delete_slider');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_slider');
    }
}
