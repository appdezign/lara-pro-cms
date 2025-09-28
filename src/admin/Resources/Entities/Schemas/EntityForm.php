<?php

namespace Lara\Admin\Resources\Entities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Lara\Admin\Enums\EntityGroup;
use Lara\Admin\Enums\EntityOrder;
use Lara\Admin\Enums\NavGroup;

use Lara\Admin\Resources\Entities\EntityResource;
use Lara\Admin\Resources\Entities\RelationManagers\CustomFieldsRelationManager;
use Lara\Admin\Resources\Entities\RelationManagers\EntityViewsRelationManager;
use Lara\Admin\Resources\Entities\RelationManagers\EntRelRelationManager;

use Njxqlus\Filament\Components\Forms\RelationManager;

class EntityForm
{

	private static function rs(): EntityResource
	{
		$class = EntityResource::class;

		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{

		return $schema
			->components([
				Tabs::make('Tabs')
					->columnSpanFull()
					->tabs([
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.info', true))
							->schema([
								Section::make('info')
									->collapsible()
									->schema(static::getInfoSection())
									->extraAttributes(['class' => 'first-entity-section']),
							]),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.columns', true))
							->schema([
								Section::make('columns')
									->collapsible()
									->schema(static::getColumnsSection())
									->extraAttributes(['class' => 'first-entity-section']),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.object_relations', true))
							->schema([
								Section::make('objectrelations')
									->collapsible()
									->schema(static::getObjectRelationsSection())
									->extraAttributes(['class' => 'first-entity-section']),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.filters', true))
							->schema([
								Section::make('filters')
									->collapsible()
									->schema(static::getFilterSection())
									->extraAttributes(['class' => 'first-entity-section']),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.sections', true))
							->schema([
								Section::make('Table')
									->collapsible()
									->schema(static::getTableSection()),
								Section::make('Form')
									->collapsible()
									->schema(static::getFormSection()),
								Section::make('Actions')
									->collapsible()
									->schema(static::getActionSection()),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),
						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.media', true))
							->schema([
								Section::make('Images')
									->collapsible()
									->schema(static::getImageSection()),
								Section::make('Gallery')
									->collapsible()
									->schema(static::getGallerySection()),
								Section::make('Video')
									->collapsible()
									->schema(static::getVideoSection()),
								Section::make('Files')
									->collapsible()
									->schema(static::getFileSection()),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),

						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.sort_order', true))
							->schema([
								Section::make('Sort Order')
									->collapsible()
									->schema(static::getSortOrderSection())
									->extraAttributes(['class' => 'first-entity-section']),
							])
							->visible(fn(Get $get, string $operation) => $operation == 'edit'),

						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.custom_fields', true))
							->schema([
							RelationManager::make()->manager(CustomFieldsRelationManager::class)
						]),

						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.entity_views', true))
							->schema([
								RelationManager::make()->manager(EntityViewsRelationManager::class)
							]),

						Tab::make(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.tabs.entity_relations', true))
							->schema([
								RelationManager::make()->manager(EntRelRelationManager::class)
							]),

					])
					->persistTab()
					->id('entity-tab'),
			]);
	}

	public static function getInfoSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('title')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.title'))
			->visible(fn(string $operation): bool => $operation === 'edit');
		$rows[] = TextInput::make('resource_slug')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource_slug'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('label_single')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.label_single'))
			->required()
			->disabled(fn(string $operation): bool => $operation === 'edit');
		$rows[] = TextInput::make('resource')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.resource'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('model_class')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.model_class'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = TextInput::make('controller')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.controller'))
			->visible(fn(string $operation): bool => $operation === 'edit')
			->disabled();
		$rows[] = Select::make('nav_group')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.nav_group'))
			->options(NavGroup::toArray())
			->default('modules');
		$rows[] = TextInput::make('position')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.position'))
			->numeric();
		$rows[] = Select::make('cgroup')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.cgroup'))
			->options(EntityGroup::toArray())
			->default('entity')
			->native(false)
			->required()
			->disabled(fn(string $operation): bool => $operation === 'edit');
		$rows[] = Toggle::make('has_front_auth')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.has_front_auth'));

		return $rows;

	}

	public static function getColumnsSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('col_has_lead')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_has_lead'));
		$rows[] = Toggle::make('col_has_body')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_has_body'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('col_extra_body_fields', 0);
			});
		$rows[] = TextInput::make('col_extra_body_fields')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_extra_body_fields'))
			->numeric()
			->maxValue(config('lara.filament.max_extra_body_fields'))
			->extraAttributes(['style' => 'width:120px;'])
			->visible(fn(Get $get): bool => $get('col_has_body'));;
		$rows[] = Toggle::make('col_has_status')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_has_status'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('col_has_hideinlist', 0);
				$set('col_has_expiration', 0);
			});
		$rows[] = Toggle::make('col_has_hideinlist')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_has_hideinlist'))
			->visible(fn(Get $get): bool => $get('col_has_status'));
		$rows[] = Toggle::make('col_has_expiration')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.col_has_expiration'))
			->visible(fn(Get $get): bool => $get('col_has_status'));

		return $rows;

	}

	public static function getObjectRelationsSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('objrel_has_terms')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.objrel_has_terms'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('objrel_has_groups', 0);
				$set('objrel_group_values', null);
			});
		$rows[] = Toggle::make('objrel_has_groups')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.objrel_has_groups'))
			->live()
			->afterStateUpdated(function (callable $set, $state) {
				$set('objrel_has_terms', 0);
				if (!$state) {
					$set('objrel_group_values', null);
				}
			});

		$rows[] = TagsInput::make('objrel_group_values')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.objrel_group_values'))
			->placeholder('new group')
			->visible(fn(Get $get): bool => $get('objrel_has_groups'));

		$rows[] = Toggle::make('objrel_has_related')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.objrel_has_related'));

		$rows[] = Toggle::make('objrel_is_relatable')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.objrel_is_relatable'));

		return $rows;
	}

	public static function getFilterSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('filter_by_trashed')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_trashed'));

		$rows[] = Toggle::make('filter_by_group')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_group'));

		$rows[] = Toggle::make('filter_by_status')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_status'));

		$rows[] = Toggle::make('filter_by_category')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_category'));

		$rows[] = Toggle::make('filter_by_tag')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_tag'));

		$rows[] = Toggle::make('filter_by_author')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_by_author'));

		$rows[] = Toggle::make('filter_is_open')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.filter_is_open'));

		return $rows;
	}

	public static function getTableSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('show_search')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_search'));
		$rows[] = Toggle::make('show_batch')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_batch'));

		return $rows;

	}

	public static function getFormSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('show_author')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_author'));
		$rows[] = Toggle::make('show_status')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_status'));
		$rows[] = Toggle::make('show_seo')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_seo'));
		$rows[] = Toggle::make('show_sync')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_sync'));
		$rows[] = Toggle::make('show_opengraph')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_opengraph'));
		$rows[] = Toggle::make('show_rich_lead')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_rich_lead'));
		$rows[] = Toggle::make('show_rich_body')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_rich_body'));

		return $rows;

	}

	public static function getActionSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('show_view_action')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_view_action'));
		$rows[] = Toggle::make('show_edit_action')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_edit_action'));
		$rows[] = Toggle::make('show_delete_action')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_delete_action'));
		$rows[] = Toggle::make('show_restore_action')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.show_restore_action'));

		return $rows;

	}

	public static function getImageSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('media_has_featured')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_featured'));
		$rows[] = Toggle::make('media_has_thumb')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_thumb'));
		$rows[] = Toggle::make('media_has_hero')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_hero'));
		$rows[] = Toggle::make('media_has_icon')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_icon'));

		return $rows;

	}

	public static function getGallerySection(): array
	{

		$rows = array();
		$rows[] = Toggle::make('media_has_gallery')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_gallery'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('max_gallery', 0);
			});

		$rows[] = Slider::make('media_max_gallery')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_max_gallery'))
			->range(minValue: 1, maxValue: 100)
			->step(1)
			->default(1)
			->decimalPlaces(0)
			->tooltips()
			->visible(fn(Get $get): bool => $get('media_has_gallery'));

		return $rows;

	}

	public static function getVideoSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('media_has_videos')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_videos'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('max_videos', 0);
			});
		$rows[] = Slider::make('media_max_videos')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_max_videos'))
			->range(minValue: 1, maxValue: 100)
			->step(1)
			->default(1)
			->decimalPlaces(0)
			->tooltips()
			->visible(fn(Get $get): bool => $get('media_has_videos'));

		$rows[] = Toggle::make('media_has_videofiles')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_videofiles'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('max_videofiles', 0);
			});
		$rows[] = Slider::make('media_max_videofiles')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_max_videofiles'))
			->range(minValue: 1, maxValue: 100)
			->step(1)
			->default(1)
			->decimalPlaces(0)
			->tooltips()
			->visible(fn(Get $get): bool => $get('media_has_videofiles'));

		return $rows;

	}

	public static function getFileSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('media_has_files')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_has_files'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('max_files', 0);
			});

		$rows[] = Slider::make('media_max_files')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.media_max_files'))
			->range(minValue: 1, maxValue: 100)
			->step(1)
			->default(1)
			->decimalPlaces(0)
			->tooltips()
			->visible(fn(Get $get): bool => $get('media_has_files'));

		return $rows;

	}

	public static function getSortOrderSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('sort_is_sortable')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.sort_is_sortable'))
			->live()
			->afterStateUpdated(function (callable $set) {
				$set('sort_primary_field', null);
				$set('sort_primary_order', null);
				$set('sort_secondary_field', null);
				$set('sort_secondary_order', null);
			});
		$rows[] = Select::make('sort_primary_field')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.sort_primary_field'))
			->options((function (Get $get): array {
				return static::getSortFields($get('resource_slug'), $get('cgroup'));
			}))
			->default('id')
			->native(false)
			->selectablePlaceholder(false)
			->required()
			->visible(fn(Get $get): bool => !$get('sort_is_sortable'));
		$rows[] = Select::make('sort_primary_order')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.sort_primary_order'))
			->options(EntityOrder::toArray())
			->default('asc')
			->native(false)
			->selectablePlaceholder(false)
			->required()
			->visible(fn(Get $get): bool => !$get('sort_is_sortable'));
		$rows[] = Select::make('sort_secondary_field')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.sort_secondary_field'))
			->options((function (Get $get): array {
				return static::getSortFields($get('resource_slug'), $get('cgroup'));
			}))
			->native(false)
			->selectablePlaceholder(true)
			->visible(fn(Get $get): bool => !$get('sort_is_sortable'));
		$rows[] = Select::make('sort_secondary_order')
			->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.sort_secondary_order'))
			->options(EntityOrder::toArray())
			->native(false)
			->selectablePlaceholder(true)
			->visible(fn(Get $get): bool => !$get('sort_is_sortable'));

		return $rows;

	}

	private static function getSortFields(string $slug, string $group): array
	{
		$prefix = config('lara-common.database.entity.' . $group . '_prefix');
		$columns = \Illuminate\Support\Facades\Schema::getColumnListing($prefix . $slug);
		$choices = [];
		foreach ($columns as $column) {
			$choices[$column] = $column;
		}

		if (empty($choices)) {
			$choices = ['id' => 'id'];
		}

		return $choices;
	}

}
