<?php

namespace Lara\Admin\Traits;

trait HasParams
{

	public static function getRequestParam(string $param, $default = null, $tag = 'global', $reset = false)
	{
		$tag = '_lara_' . $tag;
		if (request()->has($param) || $reset === true) {
			$value = request()->get($param);
			static::saveToSession($tag, $param, $value);
		} else {
			if (session()->has($tag)) {
				$tagSession = session($tag);
				if (array_key_exists($param, $tagSession)) {
					if (!empty($tagSession[$param])) {
						$value = $tagSession[$param];
					} else {
						$value = $default;
						static::saveToSession($tag, $param, $value);
					}
				} else {
					$value = $default;
					static::saveToSession($tag, $param, $value);
				}
			} else {
				$value = $default;
				static::saveToSession($tag, $param, $value);
			}
		}
		if ($value == 'true') {
			return true;
		} elseif ($value == 'false') {
			return false;
		} else {
			return $value;
		}
	}

	public static function saveToSession($tag, $param, $value): void
	{
		if (session()->has($tag)) {
			$tagSession = session($tag);
			$tagSession[$param] = $value;
			session([$tag => $tagSession]);
		} else {
			session([
				$tag => [
					$param => $value,
				],
			]);
		}
	}

}
