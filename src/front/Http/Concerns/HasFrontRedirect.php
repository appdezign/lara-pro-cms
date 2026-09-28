<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\RedirectResponse;

trait HasFrontRedirect
{
    /**
     * @return RedirectResponse
     */
    private function processRedirect($request, $routename)
    {

        $queryString = $request->getQueryString();

        // catch redirects to full urls
        if (str_starts_with($routename, 'http')) {
            return $this->getRedirectToUrl($routename);
        }

        $parts = explode('.', $routename);

        $newUrl = null;

        if (count($parts) == 3) {
            // assume it's an actual routename
            [$prefix, $redirect, $url] = explode('.', $routename);
            $newUrl = str_replace('|', '/', $url);
        } elseif (count($parts) == 2) {
            if ($parts[1] == 'html') {
                // assume it's a url of a detail page
                $newUrl = $routename;
            } else {
                return $this->getRedirectHome();
            }
        } elseif (count($parts) == 1) {
            // assume it's a url
            $newUrl = $routename;
        } else {
            return $this->getRedirectHome();
        }

        if ($queryString) {
            $newUrl = $newUrl.'?'.$queryString;
        }

        // redirect
        return $this->getRedirectToUrl($newUrl);
    }

    /**
     * @return RedirectResponse
     */
    private function getRedirectHome()
    {
        return redirect()->route('special.home.show');
    }

    /**
     * @return RedirectResponse
     */
    private function getRedirectSetup()
    {
        return redirect()->route('setup.show');
    }

    /**
     * @return RedirectResponse
     */
    private function getRedirectToUrl($url)
    {
        return redirect($url);
    }
}
