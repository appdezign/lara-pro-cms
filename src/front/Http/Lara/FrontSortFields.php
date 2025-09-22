<?php

namespace Lara\Front\Http\Lara;

/**
 * Class SortFields
 * Handles sorting fields and their ordering for data queries
 */
class FrontSortFields
{
	protected ?string $primaryField = null;
	protected ?string $primaryOrder = null;
	protected ?string $secondaryField = null;
	protected ?string $secondaryOrder = null;

	/**
	 * Constructor for SortFields class
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Get the primary sorting field
	 *
	 * @return string|null
	 */
	public function getPrimaryField()
	{
		return $this->primaryField;
	}

	/**
	 * Set the primary sorting field
	 *
	 * @param string $primaryField
	 * @return void
	 */
	public function setPrimaryField(string $primaryField)
	{
		$this->primaryField = $primaryField;
	}

	/**
	 * Get the primary sort order
	 *
	 * @return string|null
	 */
	public function getPrimaryOrder()
	{
		return $this->primaryOrder;
	}

	/**
	 * Set the primary sort order
	 *
	 * @param string $primaryOrder
	 * @return void
	 */
	public function setPrimaryOrder(string $primaryOrder)
	{
		$this->primaryOrder = $primaryOrder;
	}

	/**
	 * Get the secondary sorting field
	 *
	 * @return string|null
	 */
	public function getSecondaryField()
	{
		return $this->secondaryField;
	}

	/**
	 * Set the secondary sorting field
	 *
	 * @param string $secondaryField
	 * @return void
	 */
	public function setSecondaryField(string $secondaryField)
	{
		$this->secondaryField = $secondaryField;
	}

	/**
	 * Get the secondary sort order
	 *
	 * @return string|null
	 */
	public function getSecondaryOrder()
	{
		return $this->secondaryOrder;
	}

	/**
	 * Set the secondary sort order
	 *
	 * @param string $secondaryOrder
	 * @return void
	 */
	public function setSecondaryOrder(string $secondaryOrder)
	{
		$this->secondaryOrder = $secondaryOrder;
	}



}