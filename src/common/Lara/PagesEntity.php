<?php

namespace Lara\Common\Lara;

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
