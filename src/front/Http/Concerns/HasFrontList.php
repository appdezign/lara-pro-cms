<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\Request;
use Lara\Common\Models\Tag;
use Lara\Front\Http\Lara\FrontActiveRoute;
use Lara\Front\Http\Lara\FrontParams;
use Lara\Front\Services\FrontListBuilder;

/**
 * Object lists for a front controller: pagination, filtering and sorting.
 *
 * The logic lives in FrontListBuilder, which takes FrontTermRepository as a
 * constructor dependency. This trait is the compatibility shim that keeps the
 * existing controller call sites working; new code should inject
 * FrontListBuilder instead.
 */
trait HasFrontList
{
    private function frontListBuilder(): FrontListBuilder
    {
        return app(FrontListBuilder::class);
    }

    private function getFrontObjects(Request $request, string $language, object $entity, FrontActiveRoute $activeroute, ?Tag $menutaxonomy = null, ?FrontParams $params = null)
    {
        return $this->frontListBuilder()->getFrontObjects($request, $language, $entity, $activeroute, $menutaxonomy, $params);
    }

    private function getNextObject(string $language, object $entity, FrontActiveRoute $activeroute, object $object, object $params, $menutaxonomy = null, $override = null)
    {
        return $this->frontListBuilder()->getNextObject($language, $entity, $activeroute, $object, $params, $menutaxonomy, $override);
    }

    private function getPrevObject(string $language, object $entity, FrontActiveRoute $activeroute, object $object, object $params, $menutaxonomy = null, $override = null)
    {
        return $this->frontListBuilder()->getPrevObject($language, $entity, $activeroute, $object, $params, $menutaxonomy, $override);
    }

    private function cleanupFrontSearchString(string $str)
    {
        return $this->frontListBuilder()->cleanupFrontSearchString($str);
    }

    private function getFrontParams(object $entity, FrontActiveRoute $activeroute, Request $request)
    {
        return $this->frontListBuilder()->getFrontParams($entity, $activeroute, $request);
    }

    private function getFrontRequestParam(Request $request, string $param, ?string $default = null, ?string $resourceSlug = null, bool $reset = false)
    {
        return $this->frontListBuilder()->getFrontRequestParam($request, $param, $default, $resourceSlug, $reset);
    }

    private function getEntityTerms(string $language, object $entity, ?Tag $activetag)
    {
        return $this->frontListBuilder()->getEntityTerms($language, $entity, $activetag);
    }

    private function setTaxonomyFilter($data, string $language, object $entity)
    {
        return $this->frontListBuilder()->setTaxonomyFilter($data, $language, $entity);
    }
}
