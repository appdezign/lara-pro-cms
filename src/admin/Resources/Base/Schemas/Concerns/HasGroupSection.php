<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

trait HasGroupSection
{
	private static function getGroupSection($operation): array
	{

		$groupValues = static::getEntity()->objrel_group_values;

		if ($groupValues) {
			$options = array_combine($groupValues, $groupValues);
			$default = array_key_first($options);
		} else {
			$options = [];
			$default = null;
		}

		$disabled = false;

		if (static::getSlug() == 'pages') {
			if (!Auth::user()->hasRole('super_admin') || $operation == 'edit') {
				$disabled = true;
			}
		}

		$rows = array();

		$rows[] = Select::make('cgroup')
			->label(_q('lara-admin::default.column.cgroup', true))
			->options(array_combine($options, $options))
			->default($default)
			->disabled($disabled);

		if ($disabled) {
			$rows[] = Hidden::make('cgroup');
		}

		return $rows;
	}
}