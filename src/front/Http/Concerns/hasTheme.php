<?php

namespace Lara\Front\Http\Concerns;

trait hasTheme
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
