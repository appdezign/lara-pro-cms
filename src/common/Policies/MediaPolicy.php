<?php

namespace Lara\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Lara\Common\Models\User;

use Awcodes\Curator\Models\Media;

class MediaPolicy
{
	use HandlesAuthorization;

	public function delete(User $user, Media $media): bool
	{
		return $media->in_use == 0;
	}
	/**
	 * Determine whether the user can bulk delete.
	 */
	public function deleteAny(User $user): bool
	{
		return false;
	}
}