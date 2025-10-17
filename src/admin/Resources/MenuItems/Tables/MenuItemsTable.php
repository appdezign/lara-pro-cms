<?php

namespace Lara\Admin\Resources\MenuItems\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Lara\Admin\Resources\MenuItems\MenuItemResource;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasNestedSet;
use Lara\Admin\Traits\HasParams;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Menu;
use Lara\Common\Models\Page;
use Lara\Common\Models\Tag;

class MenuItemsTable
{

	use HasLanguage;
	use HasNestedSet;
	use HasParams;

	protected static ?string $clanguage = null;

	public static function rs(): MenuItemResource
	{
		$class = MenuItemResource::class;
		return new $class;
	}

	public static function configure(Table $table): Table
	{
		static::setContentLanguage();

		return $table
			->recordUrl(null)
			->recordAction(null)
			->columns([
				IconColumn::make('is_home')
					->label('')
					->width('5%')
					->icon(function ($state, $record) {
						return static::getMenuItemIcon($state, $record);
					})
					->color('secondary')
					->size('sm'),
				TextColumn::make('title')
					->label('')
					->width('35%')
					->html()
					->url(function ($record) {
						if ($record->publish && $record->routename) {
							// TODO
							return route('filament.admin.pages.dashboard');
							// return route($record->routename);
						} else {
							return null;
						}
					}, true)
					->getStateUsing(fn($record) => static::formatNestedTitle($record->title, $record->depth))
					->formatStateUsing(fn($state, $record) => ($record->publish == 0) ? '<span class="text-gray-400">' . $state . '</span>' : $state)
					->searchable(),
				IconColumn::make('locked_by_admin')
					->label('')
					->width('5%')
					->boolean()
					->trueIcon('bi-lock')
					->trueColor('danger')
					->state(fn($record) => ($record->locked_by_admin) ? true : null)
					->size('sm'),
				IconColumn::make('route_has_auth')
					->label('')
					->width('5%')
					->boolean()
					->trueIcon('bi-box-arrow-in-right')
					->trueColor('danger')
					->state(fn($record) => ($record->route_has_auth) ? true : null)
					->size('md'),
				TextColumn::make('type')
					->label('')
					->width('10%')
					->html()
					->formatStateUsing(fn($state, $record) => ($record->publish == 0) ? '<span class="text-gray-400">' . $state->value . '</span>' : $state->value),
				TextColumn::make('content')
					->label('')
					->width('30%')
					->html()
					->getStateUsing(fn($record) => static::getMenuItemContent($record))
					->formatStateUsing(fn($state, $record) => ($record->publish == 0) ? '<span class="text-gray-400"><em>' . $state . '</em></span>' : '<em>' . $state . '</em>'),
			])
			->filters([
				SelectFilter::make('menu_id')
					->options(Menu::pluck('title', 'id')->toArray())
					->default(Menu::where('title', 'main')->first()->value('id'))
					->selectablePlaceholder(false)
			], layout: FiltersLayout::AboveContent)
			->deferFilters(false)
			->persistFiltersInSession()
			->actions([
				EditAction::make()
					->label(''),
				DeleteAction::make()
					->label(''),
			])
			->modifyQueryUsing(fn(Builder $query) => $query->langIs(static::$clanguage))
			->defaultSort('position', 'asc')
			->paginated(false);
	}

	private static function getMenuItemIcon($state, $record): string
	{

		$icon = '';
		if ($record->type->value == 'page') {
			if ($state == 1) {
				$icon = 'bi-house-door-fill';
			} else {
				$icon = 'bi-file-earmark-text';
			}
		} elseif ($record->type->value == 'entity') {
			$icon = 'bi-box';
		} elseif ($record->type->value == 'form') {
			$icon = 'bi-file-earmark-text';
		} elseif ($record->type->value == 'parent') {
			$icon = 'bi-folder2';
		} elseif ($record->type->value == 'url') {
			$icon = 'bi-link';
		}

		return $icon;
	}

	private static function getMenuItemContent($record)
	{

		$contentTitle = null;

		if ($record->type->value == 'page') {
			$page = Page::find($record->object_id);
			$contentTitle = ($page) ? $page->title : null;

		} elseif ($record->type->value == 'parent') {
			$contentTitle = '&ndash;';

		} elseif ($record->type->value == 'entity') {
			$entity = Entity::find($record->entity_id);
			if ($record->tag_id) {
				$tag = Tag::find($record->tag_id);
				if ($tag) {
					$contentTitle = $entity->title . '&nbsp; &rsaquo; ' . $tag->title;
				} else {
					$contentTitle = $entity->title;
				}

			} else {
				$contentTitle = $entity->title;
			}

		} elseif ($record->type->value == 'form') {
			$entity = Entity::find($record->entity_id);
			$contentTitle = $entity->title;

		} elseif ($record->type->value == 'url') {
			$contentTitle = $record->url;

		}

		return $contentTitle;
	}
}
