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
     * @return void
     */
    public function setXtraTags(string $taxonomySlug, array $xtratags)
    {
        $this->xtratags[$taxonomySlug] = $xtratags;
    }
}
