<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\Request;
use Lara\Front\Services\FrontSecurityGuard;

/**
 * Spam and validation checks for front form submissions.
 *
 * The logic lives in FrontSecurityGuard, a stateless service. This trait is
 * the compatibility shim that keeps the existing controller call sites
 * working; new code should inject FrontSecurityGuard instead.
 */
trait HasFrontSecurity
{
    private function frontSecurityGuard(): FrontSecurityGuard
    {
        return app(FrontSecurityGuard::class);
    }

    private function detectSpam(object $entity, object $object, array $fieldtypes)
    {
        return $this->frontSecurityGuard()->detectSpam($entity, $object, $fieldtypes);
    }

    private function normalizeFormInput(object $entity, Request $request): void
    {
        $this->frontSecurityGuard()->normalizeFormInput($entity, $request);
    }

    private function getValidationRules(object $entity)
    {
        return $this->frontSecurityGuard()->getValidationRules($entity);
    }
}
