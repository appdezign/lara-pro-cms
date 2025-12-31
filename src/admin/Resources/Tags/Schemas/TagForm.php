<?php

namespace Lara\Admin\Resources\Tags\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Lara\Admin\Resources\Tags\Pages\ListTags;
use Lara\Admin\Resources\Tags\TagResource;
use Lara\Common\Models\Tag;
use Lara\Common\Models\Taxonomy;

trait TagForm
{

	private static function getTagFormTabs(): array
	{

		$tabs = array();

		$tabs[] = Tab::make('Content')
			->schema([
				Section::make('Content')
					->schema(static::getTagContentSection()),
			]);

		$tabs[] = Tab::make(_q('lara-admin::default.tabs.media', true))
			->schema([
				Section::make(_q('lara-admin::default.section.main_images', true))
					->columnSpanFull()
					->collapsible()
					->schema(static::getMainImageSection())
					->extraAttributes(['class' => 'lara-media-tab'])
			])
			->visible(fn(string $operation) => $operation === 'edit');

		return $tabs;

	}

	private static function getTagContentSection(): array
	{

		static::setContentLanguage();

		static::$resourceSlug = static::getActiveFilterFromPage(ListTags::class, 'resource_slug', static::getDefaultResourceSlug());
		static::$taxonomyId = static::getActiveFilterFromPage(ListTags::class, 'taxonomy_id', static::getDefaultTxonomyId());

		$taxonomy = Taxonomy::find(static::$taxonomyId);

		$hasHierarchy = (bool)$taxonomy->has_hierarchy;
		$showParents = false;

		if ($hasHierarchy) {
			$parents = Tag::scoped(['language' => static::$clanguage, 'resource_slug' => static::$resourceSlug, 'taxonomy_id' => static::$taxonomyId])
				->defaultOrder()
				->get()
				->pluck('title', 'id')
				->toArray();

			if ($parents) {
				$showParents = true;
			}
		} else {
			$parents = null;
		}

		$rows = array();

		$rows[] = Hidden::make('language')
			->default((static::$clanguage));
		$rows[] = Hidden::make('taxonomy_id')
			->default((static::$taxonomyId));
		$rows[] = Hidden::make('resource_slug')
			->default((static::$resourceSlug));
		$rows[] = Hidden::make('parent_id')
			->default(null);
		$rows[] = Hidden::make('publish')
			->default(1);

		$rows[] = Placeholder::make('entity')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.entity'))
			->content(ucfirst(static::$resourceSlug));
		$rows[] = Placeholder::make('entity')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.taxonomy'))
			->content($taxonomy->title);

		$rows[] = Select::make('parent_id')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.parent'))
			->options($parents)
			->placeholder(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.parent_none'))
			->visible(fn(string $operation): bool => $showParents && $operation === 'create');

		$rows[] = TextInput::make('title')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'));

		// Slug
		$rows[] = TextInput::make('slug')
			->label(_q('lara-admin::default.column.slug'))
			->maxLength(255)
			->hintIcon(fn(Get $get): ?string => $get('slug_lock') ? 'bi-lock-fill' : null)
			->disabled()
			->visible(fn($operation) => $operation == 'edit');
		$rows[] = Toggle::make('slug_edit')
			->label(_q('lara-admin::default.column.slug_edit'))
			->live()
			->visible(fn($operation) => $operation == 'edit');
		$rows[] = Fieldset::make(_q('lara-admin::default.group.slug_edit'))
			->schema([
				TextInput::make('slug')
					->label(_q('lara-admin::default.column.slug'))
					->maxLength(255)
					->disabled(fn(Get $get): bool => $get('slug_lock')),
				Toggle::make('slug_lock')
					->label(_q('lara-admin::default.column.slug_lock'))
					->live(),
			])
			->visible(fn(Get $get): bool => $get('slug_edit'));

		$rows[] = RichEditor::make('body')
			->label(_q('lara-admin::default.column.body'))
			->extraInputAttributes(['style' => 'min-height: 8rem;']);

		$rows[] = Toggle::make('locked_by_admin')->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.locked_by_admin'));

		return $rows;
	}

	private static function rs(): TagResource
	{
		$class = TagResource::class;

		return new $class;
	}

}
