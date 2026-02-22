<?php

namespace Lara\Front\Http\Concerns;

trait HasTheme
{

	private function getFrontTheme()
	{

		if (config('theme.active')) {
			$theme = config('theme.active');
		} else {
			// Fallback
			$theme = 'demo';
		}

		return $theme;

	}

	function getParentTheme()
	{
		return config('theme.parent');
	}


}
