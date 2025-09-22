<?php

namespace Lara\Admin\Resources\Translations\Tables;

use Filament\Actions\EditAction;

use Filament\Forms\Components\Select;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Lara\Admin\Resources\Translations\TranslationResource;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasParams;
use Lara\Common\Models\Translation;

class TranslationsTable
{

	use HasLanguage;
	use HasParams;

	protected static ?string $clanguage = null;

	private static function rs(): TranslationResource
	{
		$class = TranslationResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{
		static::setContentLanguage();

		return $table
			->columns([
				TextColumn::make('language')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.language')),
				TextColumn::make('module')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.module')),
				TextColumn::make('resource')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource')),
				TextColumn::make('tag')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.tag')),
				TextColumn::make('key')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.key'))
					->searchable(),
				TextColumn::make('value')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.value')),
			])
			->filters([

				Filter::make('filter')
					->columnSpanFull()
					->columns(5)
					->schema([

						Select::make('language')
							->options(Translation::select('language')->distinct()->pluck('language', 'language')->toArray())
						->default(static::$clanguage),

						Select::make('status')
							->options([
								'all' => 'all',
								'new' => 'new',
							])
							->default('new'),

						// Dependent filter #1
						Select::make('module')
							->options(Translation::select('module')->distinct()->pluck('module', 'module')->toArray())
							->afterStateUpdated(function (callable $set) {
								$set('resource', null);
								$set('tag', null);
							}),

						// Dependent filter #2
						Select::make('resource')
							->options(function (callable $get) {
								return Translation::select('resource')
									->distinct()
									->where('module', $get('module'))
									->orderBy('resource')
									->pluck('resource', 'resource')
									->toArray();

							})
							->afterStateUpdated(function (callable $set) {
								$set('tag', null);
							})
							->visible(fn(callable $get) => !empty($get('module'))),

						// Dependent filter #3
						Select::make('tag')
							->options(
								function (callable $get) {
									return Translation::select('tag')
										->distinct()
										->where('module', $get('module'))
										->where('resource', $get('resource'))
										->orderBy('tag')
										->pluck('tag', 'tag')->toArray();
								})
							->visible(fn(callable $get) => !empty($get('module')) && !empty($get('resource'))),


					])
					->query(function (Builder $query, array $data): Builder {

						// Build query manually
						if ($data['status'] == 'new') {
							$query->where(DB::raw("substring(value, 1, 1)"), '=', '_');
						}

						if ($data['language']) {
							$query->where('language', $data['language']);
						}
						if ($data['module']) {
							$query->where('module', $data['module']);
						}
						if ($data['resource']) {
							$query->where('resource', $data['resource']);
						}
						if ($data['tag']) {
							$query->where('tag', $data['tag']);
						}

						return $query;
					}),

			], layout: FiltersLayout::AboveContent)
			->deferFilters(false)
			->actions([
				EditAction::make()
					->label('')
					->modal(),
			])
			->bulkActions([
				//
			])
			->modifyQueryUsing(function (Builder $query) {
				return $query->orderBy('module')->orderBy('resource')->orderBy('tag');
			});
	}
}
