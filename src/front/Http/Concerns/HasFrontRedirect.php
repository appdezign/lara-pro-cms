<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Http\RedirectResponse;

trait HasFrontRedirect
{

	/**
	 * @param $request
	 * @param $routename
	 * @return void
	 */
	private function processRedirect($request, $routename)
	{

		$queryString = $request->getQueryString();

		// catch redirects to full urls
		if (str_starts_with($routename, 'http')) {
			$this->processRedirectToUrl($routename);
		}

		$parts = explode('.', $routename);

		$newUrl = null;

		if (sizeof($parts) == 3) {
			// assume it's an actual routename
			list($prefix, $redirect, $url) = explode('.', $routename);
			$newUrl = str_replace('|', '/', $url);
		} elseif (sizeof($parts) == 2) {
			if ($parts[1] == 'html') {
				// assume it's a url of a detail page
				$newUrl = $routename;
			} else {
				$this->processRedirectHome();
			}
		} elseif (sizeof($parts) == 1) {
			// assume it's a url
			$newUrl = $routename;
		} else {
			$this->processRedirectHome();
		}

		if ($queryString) {
			$newUrl = $newUrl . '?' . $queryString;
		}

		// redirect
		$this->processRedirectToUrl($newUrl);
	}

	/**
	 * @return RedirectResponse
	 */
	private function processRedirectHome()
	{
		return redirect()->route('special.home.show')->send();
	}

	/**
	 * @return RedirectResponse
	 */
	private function processRedirectSetup()
	{
		return redirect()->route('setup.show')->send();
	}

	/**
	 * @param $url
	 * @return RedirectResponse
	 */
	private function processRedirectToUrl($url)
	{
		return redirect($url)->send();
	}
}