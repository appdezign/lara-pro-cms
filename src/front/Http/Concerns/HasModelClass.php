<?php

namespace Lara\Front\Http\Concerns;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

/**
 * Resolves the model a front controller works with.
 *
 * The convention is that every concrete controller declares a `make()` method
 * whose return type names its model:
 *
 *     protected function make(): Blog
 *     {
 *         return Blog::create();
 *     }
 *
 * Previously this reflection lived in three byte-identical copies, in
 * BaseFrontController, FormController and BaseApiController.
 */
trait HasModelClass
{
    /**
     * The fully qualified model class for this controller.
     *
     * @throws RuntimeException when the controller does not follow the convention
     */
    protected function determineModelClass(): string
    {
        $controller = new ReflectionClass($this);

        if (! $controller->hasMethod('make')) {
            throw new RuntimeException(
                $controller->getName().' must declare a make() method whose return type names its model.'
            );
        }

        $returnType = $controller->getMethod('make')->getReturnType();

        if (! $returnType instanceof ReflectionNamedType || $returnType->isBuiltin()) {
            throw new RuntimeException(
                $controller->getName().'::make() must declare a model class as its return type.'
            );
        }

        return $returnType->getName();
    }
}
