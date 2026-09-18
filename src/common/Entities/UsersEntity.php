<?php

namespace Lara\Common\Entities;

use Lara\Common\Entities\LaraTool;

class UsersEntity extends LaraTool
{
	public ?string $resource_slug = 'users';
	protected ?string $module = 'admin';
}

