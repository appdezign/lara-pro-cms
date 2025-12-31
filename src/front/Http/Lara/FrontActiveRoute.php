<?php

namespace Lara\Front\Http\Lara;

class FrontActiveRoute
{
	protected ?string $prefix = null;
	protected ?string $method = null;
	protected ?string $active_route = null;
	protected ?string $single_route = null;
	protected ?int $object_id = null;
	protected ?int $menu_id = null;
	protected array $activetags = [];

	/**
	 * Constructor for LaraActiveRoute
	 *
	 * @param mixed $route The route parameter
	 */
	public function __construct($route)
	{
		//
	}

	/**
	 * Get the method
	 *
	 * @return string|null
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Set the method
	 *
	 * @param string|null $method The method to set
	 * @return void
	 */
	public function setMethod(string $method = null)
	{
		$this->method = $method;
	}

	/**
	 * Get the object ID
	 *
	 * @return int|null
	 */
	public function getObjectId()
	{
		return $this->object_id;
	}

	/**
	 * Set the object ID
	 *
	 * @param int|null $object_id The object ID to set
	 * @return void
	 */
	public function setObjectId(int $object_id = null)
	{
		$this->object_id = $object_id;
	}

	/**
	 * Get the menu ID
	 *
	 * @return int|null
	 */
	public function getMenuId()
	{
		return $this->menu_id;
	}

	/**
	 * Set the menu ID
	 *
	 * @param int|null $menu_id
	 * @return void
	 */
	public function setMenuId(int $menu_id = null)
	{
		$this->menu_id = $menu_id;
	}

	/**
	 * Get the prefix
	 *
	 * @return string|null
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * Set the prefix
	 *
	 * @param string|null $prefix The prefix to set
	 * @return void
	 */
	public function setPrefix(string $prefix = null)
	{
		$this->prefix = $prefix;
	}

	/**
	 * Get the active tags
	 *
	 * @return array
	 */
	public function getActiveTags()
	{
		return $this->activetags;
	}

	/**
	 * Set the active tags
	 *
	 * @param array $activetags The active tags to set
	 * @return void
	 */
	public function setActiveTags(array $activetags)
	{
		$this->activetags = $activetags;
	}

	/**
	 * Get the active route
	 *
	 * @return string|null
	 */
	public function getActiveRoute()
	{
		return $this->active_route;
	}

	/**
	 * Set the active route
	 *
	 * @param string|null $active_route The active route to set
	 * @return void
	 */
	public function setActiveRoute(string $active_route = null)
	{
		$this->active_route = $active_route;
	}

	/**
	 * Get the single route
	 *
	 * @return string|null
	 */
	public function getSingleRoute()
	{
		return $this->single_route;
	}

	/**
	 * Set the single route
	 *
	 * @param string|null $single_route
	 * @return void
	 */
	public function setSingleRoute(string $single_route = null)
	{
		$this->single_route = $single_route;
	}

}