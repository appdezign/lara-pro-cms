<?php

namespace Lara\Admin\Resources\MenuItems\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Lara\Admin\Enums\MenuItemType;
use Lara\Admin\Resources\MenuItems\MenuItemResource;
use Lara\Admin\Resources\MenuItems\Pages\ListMenuItems;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasNestedSet;
use Lara\Admin\Traits\HasParams;
use Lara\Common\Models\Entity;
use Lara\Common\Models\EntityView;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\Page;
use Lara\Common\Models\Tag;

class MenuItemForm
{

	use HasLanguage;
	use HasParams;
	use HasNestedSet;

	protected static ?string $clanguage = null;

	public static function rs(): MenuItemResource
	{
		$class = MenuItemResource::class;

		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{
		static::setContentLanguage();

		$MenuId = static::getActiveFilter(ListMenuItems::class, 'menu_id');

		return $schema
			->components([
				Section::make('Menu Item')
					->columnSpanFull()
					->schema([

						Hidden::make('language')
							->default(static::getContentLanguage()),
						Hidden::make('menu_id')
							->default($MenuId),

						TextInput::make('title')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
							->required()
							->maxLength(255),

						TextInput::make('slug')
							->label(_q('lara-admin::default.column.slug'))
							->maxLength(255)
							->hintIcon(fn(Get $get): ?string => $get('slug_lock') ? 'heroicon-s-lock-closed' : null)
							->disabled()
							->visible(fn($operation) => $operation == 'edit'),
						Toggle::make('slug_edit')
							->label(_q('lara-admin::default.column.slug_edit'))
							->live()
							->visible(fn($operation) => $operation == 'edit'),
						Fieldset::make(_q('lara-admin::default.group.slug_edit'))
							->schema([
								TextInput::make('slug')
									->label(_q('lara-admin::default.column.slug'))
									->maxLength(255)
									->disabled(fn(Get $get): bool => $get('slug_lock')),
								Toggle::make('slug_lock')
									->label(_q('lara-admin::default.column.slug_lock'))
									->live(),
							])
							->visible(fn(Get $get): bool => $get('slug_edit')),

						Select::make('parent_id')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.parent'))
							->placeholder('root')
							->options(MenuItem::langIs(static::getContentLanguage())->where('type', 'parent')->pluck('title', 'id')),
						Fieldset::make('Content')
							->columns(1)
							->schema([

								Select::make('type')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.type'))
									->live()
									->options(MenuItemType::class)
									->afterStateUpdated(function (callable $set, $state) {
										static::resetMenuContent($set, $state);
									})
									->default('page')
									->required(),

								// Page
								Select::make('object_id')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.object_id'))
									->options(Page::where('language', static::getContentLanguage())->where('cgroup', 'page')->where('publish', 1)->orderBy('title')->pluck('title', 'id')->toArray() + ['new' => '[ make new page ]'])->searchable()
									->required(fn($get) => $get('type')->value == 'page')
									->visible(fn($get) => $get('type')->value == 'page'),

								Toggle::make('is_home')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.is_home'))
									->disabled(fn($state) => static::menuHasHomePage($state, static::$clanguage))
									->visible(fn($get) => $get('type')->value == 'page'),

								// Module
								Select::make('entity_view_id')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.template'))
									->live()
									->options(EntityView::where('is_single', 0)->pluck('title', 'id')->toArray())
									->required(fn($get) => $get('type')->value == 'entity')
									->visible(fn($get) => $get('type')->value == 'entity'),

								// Form
								Select::make('entity_form_view_id')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.template'))
									->live()
									->options(EntityView::where('method', 'form')->pluck('title', 'id')->toArray())
									->required(fn($get) => $get('type')->value == 'form')
									->visible(fn($get) => $get('type')->value == 'form'),

								// Tag
								Select::make('tag_id')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.tag_id'))
									->options(fn($record) => static::getEntityTags($record))
									->placeholder(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.placeholder.tag_none'))
									->visible(fn($get, $record) => $get('type')->value == 'entity' && !empty($record->entity_view_id)),

								// URL
								TextInput::make('url')
									->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.url'))
									->maxLength(255)
									->required(fn($get) => $get('type')->value == 'url')
									->visible(fn($get) => $get('type')->value == 'url'),

							]),
						Toggle::make('publish')
							->label(_q('lara-admin::default.column.publish')),
						Toggle::make('route_has_auth')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.route_has_auth')),
						Toggle::make('locked_by_admin')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.locked_by_admin')),

					]),
			]);
	}

	private static function resetMenuContent(callable $set, $state): void
	{

		if ($state->value == 'page') {

			// set page entity, and page template
			$entity = Entity::where('resource_slug', 'pages')->first();
			if ($entity) {
				$view = $entity->views()->where('template', 'standard')->first();
				if ($view) {
					$set('entity_id', $entity->id);
					$set('entity_view_id', $view->id);
				}
			}

			$resetColumns = [
				'tag_id',
				'url',
			];
		} elseif ($state->value == 'parent') {
			$resetColumns = [
				'object_id',
				'entity_id',
				'entity_view_id',
				'tag_id',
				'url',
			];
		} elseif ($state->value == 'entity') {
			$resetColumns = [
				'object_id',
				'url',
			];
		} elseif ($state->value == 'form') {
			$resetColumns = [
				'object_id',
				'url',
			];
		} elseif ($state->value == 'url') {
			$resetColumns = [
				'object_id',
				'entity_id',
				'entity_view_id',
				'tag_id',
			];
		}

		if ($resetColumns) {
			foreach ($resetColumns as $resetColumn) {
				$set($resetColumn, null);
			}
		}

	}

	private static function menuHasHomePage($state, $language): bool
	{
		if ($state) {
			return false;
		} else {
			// check if we already have a homepage
			$check = MenuItem::langIs($language)->where('is_home', 1)->first();

			return (bool)$check;
		}
	}

	private static function getEntityTags($record): array
	{

		$tagOptions = array();

		$view = EntityView::find($record->entity_view_id);
		if ($view) {
			$entity = $view->entity;
			$tags = Tag::where('resource_slug', $entity->resource_slug)
				->whereHas('taxonomy', fn($query) => $query->where('slug', 'category'))
				->orderBy('position', 'asc')
				->get(['title', 'depth', 'id'])
				->toArray();
			foreach ($tags as $tag) {
				$tagId = $tag['id'];
				$tagTitle = static::formatNestedTitleBasic($tag['title'], $tag['depth']);
				$tagOptions[$tagId] = $tagTitle;
			}
		}

		return $tagOptions;
	}

	private static function getActiveFilter($pageClass, $filterName): ?string
	{

		$table = md5($pageClass);
		$sessionKey = "{$table}_filters";
		$activeFilter = session()->get('tables')[$sessionKey] ?? null;
		if ($activeFilter) {
			return $activeFilter[$filterName]['value'] ?? null;
		} else {
			return null;
		}
	}

}
