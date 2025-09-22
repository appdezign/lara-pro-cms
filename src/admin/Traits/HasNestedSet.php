<?php

namespace Lara\Admin\Traits;


trait HasNestedSet
{

	public static function formatNestedTitle($title, $depth): string
	{
		$prefix = '<div class="nested-indent nested-indent-'.$depth.'">&ndash;</div>';
		return $prefix .$title;
	}

	public static function formatNestedTitleBasic($title, $depth): string
	{
		$prefix = '';
		for($i = 0; $i < $depth; $i++) {
			$prefix .= '- ';
		}
		return $prefix . $title;
	}

}
