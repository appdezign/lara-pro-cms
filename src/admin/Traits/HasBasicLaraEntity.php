<?php

namespace Lara\Admin\Traits;


trait HasBasicLaraEntity
{

	// Legacy
	public static function getEntityKey(): ?string
	{
		return static::getSlug();
	}

}
