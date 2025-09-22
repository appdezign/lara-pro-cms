<?php

namespace Lara\Front\Http\Lara;

class FrontPagination
{

	protected bool $paginate = false;
	protected ?int $pagination = null;
	protected ?int $limit = null;

	public function __construct()
	{
		//
	}

	/**
	 * @return bool|null
	 */
	public function getPaginate()
	{
		return $this->paginate;
	}

	/**
	 * @param bool $paginate
	 * @return void
	 */
	public function setPaginate(bool $paginate)
	{
		$this->paginate = $paginate;
	}

	/**
	 * @return int|null
	 */
	public function getPagination()
	{
		return $this->pagination;
	}

	/**
	 * @param int|null $pagination
	 * @return void
	 */
	public function setPagination(?int $pagination)
	{
		$this->pagination = $pagination;
	}

	/**
	 * @return int|null
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * @param bool $limit
	 * @return void
	 */
	public function setLimit(bool $limit)
	{
		$this->limit = $limit;
	}

}