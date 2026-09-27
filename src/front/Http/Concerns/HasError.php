<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Support\Facades\Log;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Page;
use Lara\Common\Models\User;
use Throwable;

trait HasError
{
    /**
     * @return false|string
     */
    private function getErrorIdFromRoutename($routename)
    {
        $parts = explode('.', $routename);

        return end($parts);
    }

    /**
     * Find the stored error page for this language, or build one on the fly.
     *
     * This runs while rendering an error response, so it must never throw: if the
     * page cannot be persisted we still return an unsaved Page so the error view
     * has something to render.
     */
    private function findOrCreateErrorPage(string $errorId, string $language): Page
    {
        $slug = (config('lara.is_multi_language')) ? $errorId.'-'.$language : $errorId;

        $page = Page::langIs($language)
            ->where('slug', $slug)
            ->first();

        if ($page) {
            return $page;
        }

        $data = [
            'language' => $language,
            'title' => _q('lara-front::error.message.title', true),
            'slug' => $slug,
            'body' => _q('lara-front::error.message.body', true),
            'cgroup' => 'page',
        ];

        $entity = Entity::where('resource_slug', 'pages')->first();
        if ($entity && $entity->col_has_lead == 1) {
            $data['lead'] = '';
        }

        // the error page is owned by the admin account; without it we cannot
        // satisfy the non-null user_id, so fall back to an unsaved page
        $user = User::where('name', 'admin')->first();

        if (! $user) {
            Log::warning('lara error page: no "admin" user found, serving an unsaved error page', [
                'slug' => $slug,
                'language' => $language,
            ]);

            return new Page($data);
        }

        $data['user_id'] = $user->id;

        try {
            return Page::create($data);
        } catch (Throwable $e) {
            Log::error('lara error page: could not persist error page', [
                'slug' => $slug,
                'language' => $language,
                'exception' => $e,
            ]);

            return new Page($data);
        }
    }
}
