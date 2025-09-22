<?php

namespace Lara\Common\Lara;

use Lara\Common\Lara\LaraEntity;

class UsersEntity extends LaraEntity
{
	public ?string $resource_slug = 'user';
	protected ?string $module = 'admin';
}

