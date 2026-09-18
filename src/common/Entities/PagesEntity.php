<?php

namespace Lara\Common\Entities;

class PagesEntity extends LaraEntity
{

	/**
	 * @var string|null
	 */
	protected ?string $module = 'admin';

	/**
	 * @var string|null
	 */
	public ?string $resource_slug = 'pages';

}
