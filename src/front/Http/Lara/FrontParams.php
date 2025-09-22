<?php

namespace Lara\Front\Http\Lara;

class FrontParams
{
	protected ?string $viewtype = null;
	protected bool $isgrid = false;
	protected ?string $listtype = null;
	protected ?string $vtype = null;
	protected ?string $showtags = null;
	protected ?string $tagsview = null;
	protected int $gridcols = 0;
	protected int $gridcol = 0;
	protected bool $paginate = false;
	protected bool $infinite = false;
	protected bool $prevnext = false;
	protected bool $filter = false;
	protected ?string $filterbytaxonomy = null;
	protected ?string $taxonomy = null;
	protected bool $isdefaultaxonomy = false;
	protected array $xtratags = [];

	public function __construct()
	{
		//
	}

	/**
	 * @return string|null
	 */
	public function getViewType()
	{
		return $this->viewtype;
	}

	/**
	 * @param string|null $viewtype
	 * @return void
	 */
	public function setViewType(?string $viewtype)
	{
		$this->viewtype = $viewtype;
	}

	/**
	 * @return bool
	 */
	public function getIsGrid()
	{
		return $this->isgrid;
	}

	/**
	 * @param bool $isgrid
	 * @return void
	 */
	public function setIsGrid(bool $isgrid)
	{
		$this->isgrid = $isgrid;
	}

	/**
	 * @return string|null
	 */
	public function getListType()
	{
		return $this->listtype;
	}

	/**
	 * @param string|null $listtype
	 * @return void
	 */
	public function setListType(?string $listtype)
	{
		$this->listtype = $listtype;
	}

	/**
	 * @return string|null
	 */
	public function getVType()
	{
		return $this->vtype;
	}

	/**
	 * @param string|null $vtype
	 * @return void
	 */
	public function setVType(?string $vtype)
	{
		$this->vtype = $vtype;
	}

	/**
	 * @return string|null
	 */
	public function getShowTags()
	{
		return $this->showtags;
	}

	/**
	 * @param string|null $showtags
	 * @return void
	 */
	public function setShowTags(?string $showtags)
	{
		$this->showtags = $showtags;
	}

	/**
	 * @return string|null
	 */
	public function getTagsView()
	{
		return $this->tagsview;
	}

	/**
	 * @param string|null $tagsview
	 * @return void
	 */
	public function setTagsView(?string $tagsview)
	{
		$this->tagsview = $tagsview;
	}

	/**
	 * @return int
	 */
	public function getGridCols()
	{
		return $this->gridcols;
	}

	/**
	 * @param int $gridcols
	 * @return void
	 */
	public function setGridCols(int $gridcols)
	{
		$this->gridcols = $gridcols;
	}

	/**
	 * @return int
	 */
	public function getGridCol()
	{
		return $this->gridcol;
	}

	/**
	 * @param int $gridcol
	 * @return void
	 */
	public function setGridCol(int $gridcol)
	{
		$this->gridcol = $gridcol;
	}

	/**
	 * @return bool
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
	 * @return bool
	 */
	public function getInfinite()
	{
		return $this->infinite;
	}

	/**
	 * @param bool $infinite
	 * @return void
	 */
	public function setInfinite(bool $infinite)
	{
		$this->infinite = $infinite;
	}

	/**
	 * @return bool
	 */
	public function getPrevNext()
	{
		return $this->prevnext;
	}

	/**
	 * @param bool $prevnext
	 * @return void
	 */
	public function setPrevNext(bool $prevnext)
	{
		$this->prevnext = $prevnext;
	}

	/**
	 * @return bool
	 */
	public function getFilter()
	{
		return $this->filter;
	}

	/**
	 * @param bool $filter
	 * @return void
	 */
	public function setFilter(bool $filter)
	{
		$this->filter = $filter;
	}

	/**
	 * @return string|null
	 */
	public function getFilterByTaxonomy()
	{
		return $this->filterbytaxonomy;
	}

	/**
	 * @param string|null $filterbytaxonomy
	 * @return void
	 */
	public function setFilterByTaxonomy(?string $filterbytaxonomy)
	{
		$this->filterbytaxonomy = $filterbytaxonomy;
	}

	/**
	 * @return string|null
	 */
	public function getTaxonomy()
	{
		return $this->taxonomy;
	}

	/**
	 * @param string|null $taxonomy
	 * @return void
	 */
	public function setTaxonomy(?string $taxonomy)
	{
		$this->taxonomy = $taxonomy;
	}

	/**
	 * @return bool
	 */
	public function getIsDefaultTaxonomy()
	{
		return $this->isdefaultaxonomy;
	}

	/**
	 * @param bool $isdefaultaxonomy
	 * @return void
	 */
	public function setIsDefaultTaxonomy(bool $isdefaultaxonomy)
	{
		$this->isdefaultaxonomy = $isdefaultaxonomy;
	}

	/**
	 * @return array|null
	 */
	public function getXtraTags()
	{
		return $this->xtratags;
	}

	/**
	 * @param string $taxonomySlug
	 * @param array $xtratags
	 * @return void
	 */
	public function setXtraTags(string $taxonomySlug, array $xtratags)
	{
		$this->xtratags[$taxonomySlug] = $xtratags;
	}

}