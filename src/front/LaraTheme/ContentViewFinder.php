<?php

namespace Lara\Front\LaraTheme;

use Illuminate\View\FileViewFinder;
use InvalidArgumentException;
use Lara\Common\Entities\EntityRegistry;
use Throwable;

/**
 * The view finder of the site: a content view a theme does not have falls back
 * to the base templates of its content group.
 *
 * A missing `content.{resource slug}.{view}` resolves to
 * `content.__templates.{cgroup}.{view}` (base theme), so a content type without
 * its own views still renders, in every environment and without writing files.
 */
class ContentViewFinder extends FileViewFinder
{
    public const TEMPLATE_FOLDER = '__templates';

    /**
     * @param  string  $view
     * @return string
     */
    public function find($view)
    {
        try {
            return parent::find($view);
        } catch (InvalidArgumentException $notFound) {
            $fallback = $this->getTemplateView(trim($view));

            if ($fallback === null) {
                throw $notFound;
            }

            try {
                return $this->views[trim($view)] = parent::find($fallback);
            } catch (InvalidArgumentException) {
                throw $notFound;
            }
        }
    }

    /**
     * The template view for a content view, or null when the view is not an entity's content view.
     */
    private function getTemplateView(string $view): ?string
    {
        if (! preg_match('/^content\.([a-z0-9_-]+)\.(.+)$/i', $view, $matches) || str_starts_with($matches[1], '_')) {
            return null;
        }

        try {
            $cgroup = app(EntityRegistry::class)->find($matches[1])?->cgroup;
        } catch (Throwable) {
            return null;
        }

        return $cgroup ? 'content.'.self::TEMPLATE_FOLDER.'.'.$cgroup.'.'.$matches[2] : null;
    }
}
