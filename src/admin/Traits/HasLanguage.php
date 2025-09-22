<?php

namespace Lara\Admin\Traits;

trait HasLanguage
{

	public static function setContentLanguage(): void
	{
		static::$clanguage = static::getContentLanguage();
	}

	public static function getContentLanguage(): string
	{
		$default = config('lara.content_language.default_language');
		return static::getRequestParam('clanguage', $default);
	}
}
