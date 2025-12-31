<?php

if (!function_exists('in_array_r')) {

	/**
	 * @param string $needle
	 * @param array $haystack
	 * @param bool $strict
	 * @return bool
	 */
	function in_array_r(string $needle, array $haystack, $strict = false)
	{
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}
}

if (!function_exists('prepare_http_build_query')) {

	/**
	 * @param array $tags
	 * @return array
	 */
	function prepare_http_build_query(array $tags)
	{
		$xtratags = array();
		foreach ($tags as $xkey => $xtratag) {
			$xtratags[$xkey] = $xtratag['slug'];
		}

		return $xtratags;
	}
}
