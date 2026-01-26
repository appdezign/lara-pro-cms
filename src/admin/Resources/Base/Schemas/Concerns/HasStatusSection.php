<?php

namespace Lara\Admin\Resources\Base\Schemas\Concerns;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

trait HasStatusSection
{
	private static function getStatusSection(): array
	{

		$rows = array();

		$rows[] = Group::make([
			DateTimePicker::make('publish_from')
				->label(_q('lara-admin::default.column.publish_from'))
				->live()
				->default(now())
				->displayFormat('Y-m-d H:i:s'),
			DateTimePicker::make('publish_to')
				->label(_q('lara-admin::default.column.publish_to'))
				->live()
				->displayFormat('Y-m-d H:i:s')
				->default(null)
				->visible(fn(Get $get): bool => static::resourceHasExpiration() && $get('publish_expire')),
		]);

		$rows[] = Group::make([
			Toggle::make('publish')
				->label(_q('lara-admin::default.column.publish'))
				->inlineLabel(false)
				->live(),
			Toggle::make('publish_expire')
				->label(_q('lara-admin::default.column.expire'))
				->inlineLabel(false)
				->live()
				->afterStateUpdated(function (Set $set) {
					$set('publish_to', null);
				})
				->visible(static::resourceHasExpiration()),
			Toggle::make('publish_hide')
				->label(_q('lara-admin::default.column.hide-in-list'))
				->inlineLabel(false)
				->visible(static::resourceHasHideInList()),

		])->extraAttributes(['class' => 'lara-publish-group']);

		return $rows;
	}

	private static function getStatus(Get $get): string
	{

		if (!$get('publish')) {
			return 'Draft';
		}

		if (strtotime($get('publish_from')) > time()) {
			return 'Planned';
		}

		if (!$get('publish_expire')) {
			return 'Published';
		}

		return strtotime($get('publish_to')) < time() ? 'Expired' : 'Published';

	}

}