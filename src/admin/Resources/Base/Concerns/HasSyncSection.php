<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

trait HasSyncSection
{
	private static function getSyncSection(): array
	{
		$rows = array();

		$rows[] = Fieldset::make('remote')
			->columnSpanFull()
			->columns([
				'sm' => 2,
				'lg' => 3,
				'xl' => 4,
			])
			->live()
			->schema([
				TextInput::make('remote_url')
					->inlineLabel(false)
					->label(_q('lara-admin::default.column.sync_remote_url')),

				TextInput::make('remote_suffix')
					->inlineLabel(false)
					->label(_q('lara-admin::default.column.sync_remote_suffix'))
					->disabled(),

				TextInput::make('remote_resource')
					->inlineLabel(false)
					->label(_q('lara-admin::default.column.sync_remote_resource'))
					->disabled(),

				TextInput::make('remote_slug')
					->inlineLabel(false)
					->label(_q('lara-admin::default.column.sync_remote_slug'))
					->disabled(),

			])
			->extraAttributes(['class' => 'lara-media-section']);

		return $rows;
	}

	private static function mutateSyncData($data, $record): array
	{

		$data['remote_suffix'] = '/' . static::$clanguage . '/api/';
		$data['remote_resource'] = static::getSlug();
		$data['remote_slug'] = $record->slug;

		return $data;
	}

}