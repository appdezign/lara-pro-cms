<?php

namespace Lara\Admin\Resources\Base\Schemas;

use Cache;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Lara\Admin\Components\GeoLocationField;
use Lara\Admin\Components\LanguageVersions;
use Lara\Admin\Enums\EntityHook;
use Lara\Admin\Enums\LayoutSections;
use Lara\Common\Models\Entity;
use Lara\Common\Models\Language;
use Lara\Common\Models\MenuItem;
use Lara\Common\Models\ObjectLayout;
use Lara\Common\Models\Tag;
use Lara\Common\Models\User;

use Schmeits\FilamentCharacterCounter\Forms\Components\Textarea as TextAreaWithCounter;

trait LaraBaseForm
{

	private static function getLaraFormTabs(): array
	{

		$tabs = array();

		$tabs[] = Tab::make(_q('lara-admin::default.tabs.content', true))
			->schema(static::getContentSections());

		if (static::resourceHasTerms()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.tags', true))
				->schema([
					Section::make(_q('lara-admin::default.section.tags', true))
						->columns(2)
						->schema(static::getTagSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasMedia()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.media', true))
				->schema([
					Section::make(_q('lara-admin::default.section.main_images', true))
						->relationship('images')
						->columnSpanFull()
						->collapsible()
						->schema(static::getMainImageSection())
						->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
							return static::mutateGalleryData($data);
						})
						->extraAttributes(['class' => 'lara-media-tab'])
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasVideos()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.video', true))
				->schema([
					Section::make(_q('lara-admin::default.section.videos', true))
						->description(fn(Get $get) => (static::getMaxVideos() > 1) ? '(' . count($get('videos.entity_videos')) . '/' . static::getMaxVideos() . ')' : null)
						->relationship('videos')
						->collapsible()
						->extraAttributes(['class' => 'lara-videos-section'])
						->schema(static::getVideoSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasVideoFiles()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.videofiles', true))
				->schema([
					Section::make(_q('lara-admin::default.section.videofiles', true))
						->description(fn(Get $get) => (static::getMaxVideoFiles() > 1) ? '(' . count($get('videofiles.entity_videofiles')) . '/' . static::getMaxVideoFiles() . ')' : null)
						->relationship('videofiles')
						->collapsible()
						->extraAttributes(['class' => 'lara-videofiles-section'])
						->schema(static::getVideoFilesSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasFiles()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.files', true))
				->schema([
					Section::make(_q('lara-admin::default.section.files', true))
						->description(fn(Get $get) => (static::getMaxFiles() > 1) ? '(' . count($get('files.entity_files')) . '/' . static::getMaxFiles() . ')' : null)
						->relationship('files')
						->collapsible()
						->extraAttributes(['class' => 'lara-section-files'])
						->schema(static::getFilesSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasRelated()) {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.related', true))
				->schema([
					Section::make(_q('lara-admin::default.section.related', true))
						->relationship('related')
						->collapsible()
						->extraAttributes(['class' => 'lara-section-related'])
						->schema(static::getRelatedSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::getSlug() == 'pages') {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.layout', true))
				->schema([
					Section::make(_q('lara-admin::default.section.layout', true))
						->relationship('layout')
						->collapsible()
						->extraAttributes(['class' => 'lara-section-layout'])
						->schema(static::getLayoutSection()),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::getSlug() == 'widgets') {
			$tabs[] = Tab::make(_q('lara-admin::default.tabs.onpages', true))
				->schema([
					Section::make(_q('lara-admin::default.section.content', true))
						->collapsible()
						->schema(static::getOnPagesSection()),
				]);
		}

		return $tabs;

	}

	private static function getContentSections(): array
	{
		$sections = array();

		if (static::resourceHasStatus()) {
			if (static::resourceShowStatus()) {
				$sections[] = Section::make(_q('lara-admin::default.section.status', true))
					->description(fn(Get $get): string => static::getStatus($get))
					->columns(2)
					->collapsible()
					->schema(static::getStatusSection());
			} else {
				$sections[] = Hidden::make('publish')->default(1);
				$sections[] = Hidden::make('publish_from')->default(Carbon::now());
			}
		}

		$sections[] = Section::make(_q('lara-admin::default.section.content', true))
			->collapsible()
			->schema(static::getContentSection());

		if (static::resourceShowOpengraph()) {
			$sections[] = Section::make(_q('lara-admin::default.section.opengraph', true))
				->schema([
					ViewField::make('opengraphview')
						->view('lara-admin::partials.opengraph'),
				])
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceShowOpengraph()) {
			$sections[] = Section::make(_q('lara-admin::default.section.opengraph_advanced', true))
				->relationship('opengraph')
				->collapsible()
				->collapsed()
				->schema(static::getOpenGraphSection())
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceShowSeo()) {
			$sections[] = Section::make(_q('lara-admin::default.section.seo', true))
				->relationship('seo')
				->collapsible()
				->schema(static::getSeoSection())
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceHasGroups()) {
			$sections[] = Section::make(_q('lara-admin::default.section.cgroup', true))
				->collapsible()
				->schema(fn(string $operation) => static::getGroupSection($operation));
		}

		if (static::resourceShowAuthor()) {
			$sections[] = Section::make(_q('lara-admin::default.section.author', true))
				->collapsible()
				->schema(static::getAuthorSection());
		} else {
			$sections[] = Hidden::make('user_id')->default(auth()->id());
		}

		$sections[] = Section::make(_q('lara-admin::default.section.language_versions', true))
			->collapsible()
			->schema(static::getLanguageParentSection())
			->visible(fn(Get $get, string $operation) => $operation === 'edit' && $get('language') != static::getDefaultLanguage());

		$sections[] = Section::make(_q('lara-admin::default.section.language_versions', true))
			->collapsible()
			->schema(static::getLanguageChildrenSection())
			->visible(fn(Get $get, string $operation) => $operation === 'edit' && $get('language') == static::getDefaultLanguage());

		if (static::resourceShowSync()) {
			$sections[] = Section::make(_q('lara-admin::default.section.sync', true))
				->relationship('sync')
				->collapsible()
				->mutateRelationshipDataBeforeFillUsing(function (array $data, $record): array {
					return static::mutateSyncData($data, $record);
				})
				->mutateRelationshipDataBeforeSaveUsing(function (array $data, $record): array {
					return static::mutateSyncData($data, $record);
				})
				->schema(static::getSyncSection())
				->visible(fn(string $operation) => $operation === 'edit');
		}

		// $sections[] = CuratorPicker::make('featured_id')->label('thumbnail image');

		return $sections;
	}

	private static function mutateSyncData($data, $record): array
	{

		$data['remote_suffix'] = '/' . static::$clanguage . '/api/';
		$data['remote_resource'] = static::getSlug();
		$data['remote_slug'] = $record->slug;

		return $data;
	}

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

	private static function getContentSection(): array
	{

		static::setContentLanguage();

		$rows = array();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::BEFORE_TITLE->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Title
		$rows[] = TextInput::make('title')
			->label(_q(static::getModule() . '::' . static::getSlug() . '.column.title'))
			->maxLength(255)
			->extraAttributes(['class' => 'js-title-input'])
			->required();

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_TITLE->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Slug
		$rows[] = TextInput::make('slug')
			->label(_q('lara-admin::default.column.slug'))
			->maxLength(255)
			->hintIcon(fn(Get $get): ?string => $get('slug_lock') ? 'heroicon-s-lock-closed' : null)
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

		// Relations
		foreach (static::getEntity()->relations as $relation) {
			if ($relation->type == 'belongsTo') {
				$relatedEntityClass = $relation->relatedEntity->model_class;
				$rows[] = Select::make($relation->foreign_key)
					->label(_q(static::getModule() . '::' . static::getSlug() . '.column.' . $relation->foreign_key))
					->options($relatedEntityClass::langIs(static::$clanguage)->pluck('title', 'id')->toArray())
					->required();
			}
		}

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_SLUG->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		// Lead
		if (static::resourceHasLead()) {
			$rows = static::getRichEditorSection($rows, 'lead', static::leadHasRichEditor(), true);
		}

		// Body
		if (static::resourceHasBody()) {
			$rows = static::getRichEditorSection($rows, 'body', static::bodyHasRichEditor(), true);
		}

		$maxExtraFields = static::maxBodyFields();

		if ($maxExtraFields > 0) {
			for ($i = 1; $i <= $maxExtraFields; $i++) {
				$fieldNumber = $i + 1;
				$extraFieldname = 'body' . $fieldNumber;
				$rows = static::getRichEditorSection($rows, $extraFieldname, static::bodyHasRichEditor(), true, $fieldNumber);
			}
		}

		// Template (Pages only)
		if (static::getSlug() == 'pages') {
			$rows[] = Select::make('template')
				->label(_q('lara-admin::default.column.template'))
				->options(static::getEntity()->views()->IsSingle()->pluck('template', 'template')->toArray())
				->required();
		}

		// Custom Fields
		foreach (static::getCustomFieldsByHook(EntityHook::AFTER_LAST->value) as $customField) {
			if (!empty(static::getFilamentComponent($customField))) {
				$rows = array_merge($rows, static::getFilamentComponent($customField));
			}
		}

		$rows[] = Hidden::make('language')->default(static::$clanguage);

		return $rows;

	}

	private static function getRichEditorSection(array $rows, string $fieldname, bool $hasRichEditor = false, bool $toggle = false, ?int $extraFieldNumber = null): array
	{
		if ($hasRichEditor) {

			if ($toggle && auth()->user()->hasRole('superadmin')) {
				$rows[] = Toggle::make('show_html_' . $fieldname)
					->hiddenLabel()
					->live()
					->extraFieldWrapperAttributes(['class' => 'rich-editor-toggle-button'])
					->afterStateUpdated(function ($state, Set $set, Get $get) use ($fieldname) {
						if ($state) {
							$set('_' . $fieldname, $get($fieldname));
						} else {
							$set($fieldname, $get('_' . $fieldname));
						}
					})
					->visible(fn(Get $get): bool => is_null($extraFieldNumber) || static::templateHasExtraField($get, $extraFieldNumber));

				$rows[] = Textarea::make('_' . $fieldname)
					->label(_q('lara-admin::default.column.html'))
					->live()
					->extraInputAttributes(['style' => 'min-height: 16rem;'])
					->visible(function (Get $get) use ($fieldname, $extraFieldNumber): bool {
						if ($extraFieldNumber) {
							return static::templateHasExtraField($get, $extraFieldNumber) && $get('show_html_' . $fieldname);
						} else {
							return $get('show_html_' . $fieldname);
						}
					});

			}

			$rows[] = RichEditor::make($fieldname)
				->label(_q('lara-admin::default.column.' . $fieldname))
				->live()
				->customBlocks(config('lara-admin.rich_editor.custom_blocks'))
				->extraInputAttributes(['style' => 'min-height: 8rem;'])
				->visible(function (Get $get) use ($fieldname, $extraFieldNumber): bool {
					if ($extraFieldNumber) {
						return static::templateHasExtraField($get, $extraFieldNumber) && !$get('show_html_' . $fieldname);
					} else {
						return !$get('show_html_' . $fieldname);
					}
				});
		} else {
			$rows[] = Textarea::make($fieldname)
				->label(_q('lara-admin::default.column.' . $fieldname))
				->extraInputAttributes(['style' => 'min-height: 16rem;'])
				->visible(fn(Get $get): bool => is_null($extraFieldNumber) || static::templateHasExtraField($get, $extraFieldNumber));

		}

		return $rows;
	}

	private static function templateHasExtraField($get, $fieldNumber): bool
	{
		$template = $get('template');
		if ($template) {
			$view = static::getEntity()->views()->where('template', $template)->first();
			$templateExtraFields = $view->template_extra_fields;
			if ($templateExtraFields + 1 >= $fieldNumber) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	private static function getSeoSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('seo_title')
			->label(_q('lara-admin::default.column.seo_title'))
			->maxLength(300);

		$rows[] = TextAreaWithCounter::make('seo_description')
			->label(_q('lara-admin::default.column.seo_description'));

		$rows[] = TextAreaWithCounter::make('seo_keywords')
			->label(_q('lara-admin::default.column.seo_keywords'));

		return $rows;

	}

	private static function getOpenGraphSection(): array
	{

		$rows = array();

		$rows[] = TextInput::make('og_title')
			->label(_q('lara-admin::default.column.og_title'))
			->maxLength(300);

		$rows[] = TextAreaWithCounter::make('og_description')
			->label(_q('lara-admin::default.column.og_description'));

		/*
		$rows[] = MediaPicker::make('og_image')
			->hiddenLabel()
			->folder(static::getEntityMediaFolder());
		*/

		return $rows;

	}

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

	private static function getLanguageParentSection(): array
	{
		$rows = array();

		$rows[] = Select::make('language_parent')
			->label(_q('lara-admin::default.column.language_parent'))
			->options(function (Get $get) {
				$parents = null;
				$defaultLanguage = static::getDefaultLanguage();
				$entity = Entity::where('resource_slug', static::getSlug())->first();
				if ($entity) {
					$modelClass = $entity->model_class;
					$parents = $modelClass::langIs($defaultLanguage)->whereNot('language', $get('language'))->pluck('title', 'id')->toArray();
				}

				return $parents;
			});

		return $rows;
	}

	private static function getLanguageChildrenSection(): array
	{
		$rows = array();

		$rows[] = LanguageVersions::make('language_children')
			->label(_q('lara-admin::default.column.language_children'));

		return $rows;
	}

	private static function getDefaultLanguage(): string
	{
		return Language::where('default', 1)->pluck('code')->first();
	}

	private static function getAuthorSection(): array
	{
		$rows = array();

		$rows[] = Select::make('user_id')
			->label(_q('lara-admin::default.column.user_id'))
			->options(User::where('id', auth()->id())->pluck('name', 'id'))
			->native(false)
			->default(auth()->id())
			->selectablePlaceholder(false)
			->visible(fn($operation) => $operation == 'create');

		$rows[] = Select::make('user_id')
			->label(_q('lara-admin::default.column.user_id'))
			->relationship('user', 'name')
			->preload()
			->selectablePlaceholder(false)
			->visible(fn($operation) => $operation == 'edit');

		return $rows;

	}

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

	private static function getTagSection(): array
	{
		$rows = array();

		$rows[] = CheckboxList::make('categories')
			->label('Categories')
			->allowHtml()
			->relationship(
				titleAttribute: 'title',
				modifyQueryUsing: function ($query) {
					return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
				}
			)
			->getOptionLabelFromRecordUsing(fn($record) => static::formatNestedTitleBasic($record->title, $record->depth));

		$rows[] = CheckboxList::make('tags')
			->label('Tags')
			->relationship(
				titleAttribute: 'title',
				modifyQueryUsing: function ($query) {
					return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
				}
			);

		return $rows;
	}

	private static function getRelatedSection(): array
	{

		$rows = array();

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_page_objects', true))
			->schema([
				Repeater::make('related_page_objects')
					->label(_q('lara-admin::default.repeater.related_page_objects', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('page_object_id')
							->label(_q('lara-admin::default.repeaterfield.page', true))
							->options(function () {
								return MenuItem::where('type', 'page')->pluck('title', 'object_id')->toArray();
								// return Page::langIs('nl')->pluck('title', 'id')->toArray();
							}),
					])
					->columnSpanFull(),
			]);

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_entity_objects', true))
			->schema([
				Repeater::make('related_entity_objects')
					->label(_q('lara-admin::default.repeater.related_entity_objects', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('resource_slug')
							->label(_q('lara-admin::default.repeaterfield.resource_slug', true))
							->live()
							->options(static::getRelatableEntities()),
						Select::make('object_id')
							->label(_q('lara-admin::default.repeaterfield.object_id', true))
							->options(function (Get $get) {
								$resource_slug = $get('resource_slug');
								if ($resource_slug) {
									$entity = Entity::where('resource_slug', $resource_slug)->first();
									if ($entity) {
										$modelClass = $entity->model_class;

										return $modelClass::langIs('nl')->pluck('title', 'id')->toArray();
									}
								}
							}),
					])
					->columnSpanFull(),
			]);

		$rows[] = Fieldset::make(_q('lara-admin::default.fieldset.related_entities', true))
			->schema([
				Repeater::make('related_entities')
					->label(_q('lara-admin::default.repeater.related_entities', true))
					->defaultItems(0)
					->addActionLabel(_q('lara-admin::default.repeater.add', true))
					->addActionAlignment(Alignment::Start)
					->schema([
						Select::make('module_page_menu_id')
							->label(_q('lara-admin::default.repeaterfield.menu_item', true))
							->options(MenuItem::where('type', 'entity')->pluck('title', 'id')->toArray()),
					])
					->columnSpanFull(),
			]);

		return $rows;

	}

	private static function getLayoutSection(): array
	{

		$layout = static::getFullLayout();
		$rows = array();
		$sections = LayoutSections::toArray();
		$tablename = (new ObjectLayout)->getTable();

		foreach ($sections as $section) {

			static::checkLayoutColumn($tablename, $section);

			$rows[] = Select::make($section)
				->label(_q('lara-admin::layout.section.' . $section, true))
				->live()
				->options(function () use ($layout, $section) {
					$sectionOptions = [];
					foreach ($layout->$section as $options) {
						$optionValue = $options->partialFile;
						$optionLabel = $options->friendlyName;
						if ($options->isDefault == 'true') {
							$sectionOptions[$optionValue] = $optionLabel . ' [default]';
						} else {
							$sectionOptions[$optionValue] = $optionLabel;
						}
					}

					return $sectionOptions;
				})
				->placeholder('[default]');
		}

		return $rows;

	}

	private static function getOnPagesSection(): array
	{

		$rows = array();

		$rows[] = Toggle::make('is_global')
			->label(_q('lara-admin::default.column.is_global', true))
			->live();

		$rows[] = Fieldset::make('onpage_pages')
			->label(_q('lara-admin::default.fieldset.onpages', true))
			->schema([
				CheckboxList::make('onpages')
					->hiddenLabel()
					->relationship(
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', static::$clanguage)->whereIn('cgroup', ['page', 'module'])->orderby('cgroup', 'desc')->orderby('position');
						}
					)
					->disabled(fn(Get $get): bool => $get('is_global')),
			]);

		return $rows;

	}

	private static function getStatus(Get $get): string
	{

		if ($get('publish')) {
			if (strtotime($get('publish_from')) > time()) {
				$status_str = 'Planned';
			} else {
				if ($get('publish_expire')) {
					if (strtotime($get('publish_to')) < time()) {
						$status_str = 'Expired';
					} else {
						$status_str = 'Published';
					}
				} else {
					$status_str = 'Published';
				}
			}
		} else {
			$status_str = 'Draft';
		}

		return $status_str;

	}

	private static function checkLayoutColumn($tablename, $column): void
	{

		if (!Schema::hasColumn($tablename, $column)) {
			Schema::table($tablename, function ($table) use ($column) {
				$table->string($column)->nullable();
			});
		}
	}

	private static function getRelatableEntities(): array
	{
		$cacheKey = 'lara_relatable_entities';

		return Cache::rememberForever($cacheKey, function () {
			return MenuItem::with('entity')
				->where('type', 'entity')
				->whereHas('entity', function ($query) {
					$query->where('objrel_is_relatable', 1);
				})
				->get()
				->pluck('entity.resource_slug', 'entity.resource_slug')->toArray();
		});
	}

	private static function getCustomFieldsByHook($hook)
	{
		$cacheKey = 'lara_entity_custom_fields_' . static::getSlug() . '_' . $hook;

		return Cache::rememberForever($cacheKey, function () use ($hook) {
			return static::getEntity()->customfields()->where('field_hook', $hook)->orderBy('sort_order')->get();
		});
	}

	private static function getFilamentComponent($field): array
	{

		$rows = array();

		$state = $field->rule_state;

		$label = _q(static::getModule() . '::' . static::getSlug() . '.column.' . $field->field_name);

		switch ($field->field_type) {
			case 'string':
			case 'text':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'email':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->email()
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'number':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->numeric()
					->default(0)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'textarea':
				$rows[] = Textarea::make($field->field_name)
					->label($label)
					->extraInputAttributes(['style' => 'min-height: 8rem;'])
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'select':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->live()
					->options(fn($record) => static::getSelectFieldOptions($record, $field))
					->searchable(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'multiselect':
				$rows[] = Select::make($field->field_name)
					->label($label)
					->multiple()
					->options(array_combine($field->field_options, $field->field_options))
					->searchable(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'tagsinput':
				$rows[] = Tagsinput::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'toggle':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Toggle::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'togglebuttons':
				$rows[] = ToggleButtons::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'multitogglebuttons':
				$rows[] = ToggleButtons::make($field->field_name)
					->label($label)
					->multiple()
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkbox':
				$rows[] = Hidden::make($field->field_name);
				$rows[] = Checkbox::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'checkboxlist':
				$rows[] = CheckboxList::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'radio':
				$rows[] = Radio::make($field->field_name)
					->label($label)
					->options(array_combine($field->field_options, $field->field_options))
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'colorpicker':
				$rows[] = ColorPicker::make($field->field_name)
					->label($label)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'decimal_10_1':
			case 'decimal_14_2':
			case 'decimal_16_4':
			case 'latitude_10_8':
			case 'longitude_11_8':
				$rows[] = TextInput::make($field->field_name)
					->label($label)
					->numeric()
					->default(0)
					->step('any')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'date':
				$rows[] = DatePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'time':
				$rows[] = TimePicker::make($field->field_name)
					->label($label)
					->seconds(false)
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'datetime':
				$rows[] = DateTimePicker::make($field->field_name)
					->label($label)
					->default(now())
					->displayFormat('Y-m-d H:i')->disabled($state == 'disabled')
					->required($field->is_required == 1)
					->disabled($state == 'disabled')
					->visible(fn(Get $get) => static::getFieldState($get, $field));
				break;
			case 'geolocation':
				$rows[] = Fieldset::make(_q('lara-admin::default.group.geolocation', true))
					->schema([
						TextInput::make('geo_address')
							->label(_q('lara-admin::default.column.geo_address'))
							->columnSpanFull(),

						TextInput::make('geo_pcode')
							->label(_q('lara-admin::default.column.geo_pcode'))
							->columnSpanFull(),

						TextInput::make('geo_city')
							->label(_q('lara-admin::default.column.geo_city'))
							->columnSpanFull(),

						TextInput::make('geo_country')
							->label(_q('lara-admin::default.column.geo_country'))
							->columnSpanFull(),

						GeoLocationField::make('geo_location')
							->label(_q('lara-admin::default.column.geo_location'))
							->live()
							->native(false)
							->options([
								'auto'   => 'auto',
								'manual' => 'manual',
								'hidden' => 'hidden',
							])
							->columnSpanFull(),

						TextInput::make('geo_latitude')
							->label(_q('lara-admin::default.column.geo_latitude'))
							->visible(fn(Get $get) => $get('geo_location') != 'hidden')
							->disabled(fn(Get $get) => $get('geo_location') == 'auto')
							->extraAttributes(['class' => 'js-geo-latitude'])
							->columnSpanFull(),

						TextInput::make('geo_longitude')
							->label(_q('lara-admin::default.column.geo_longitude'))
							->visible(fn(Get $get) => $get('geo_location') != 'hidden')
							->disabled(fn(Get $get) => $get('geo_location') == 'auto')
							->extraAttributes(['class' => 'js-geo-longitude'])
							->columnSpanFull(),
					]);

		}

		// Add hidden fields if necessary
		switch ($field->field_type) {
			case 'decimal_10_1':
			case 'decimal_14_2':
			case 'decimal_16_4':
			case 'latitude_10_8':
			case 'longitude_11_8':
				$rows[] = Hidden::make($field->field_name)
					->default(0)
					->visible($state == 'hidden');
				break;
			default:
				$rows[] = Hidden::make($field->field_name)
					->visible($state == 'hidden');
		}

		return $rows;

	}

	private static function getSelectFieldOptions($record, $field): array
	{
		if (!empty($field->field_options)) {
			if ($field->field_options[0] == 'get_entity_resources') {
				return Entity::where('cgroup', 'entity')->pluck('resource_slug', 'resource_slug')->toArray();
			}
			if ($field->field_options[0] == 'get_entity_terms') {
				if ($record && $record->resource_slug) {
					return Tag::where('language', $record->language)->where('resource_slug', $record->resource_slug)->pluck('slug', 'slug')->toArray();
				} else {
					return [];
				}

			}
			if ($field->field_options[0] == 'get_widget_templates') {
				if ($record) {
					return static::getBladeTemplates($record);
				} else {
					return [];
				}
			}

		}

		return array_combine($field->field_options, $field->field_options);
	}

	private static function getFieldState($get, $field): bool
	{

		if ($field->rule_state == 'enabled') {
			return true;
		} elseif ($field->rule_state == 'disabled') {
			return true;
		} elseif ($field->rule_state == 'hidden') {
			return false;
		} elseif ($field->rule_state == 'enabledif') {
			if ($field->rule_operator == 'isequal') {
				return $get($field->rule_field) == $field->rule_value;
			} elseif ($field->rule_operator == 'isnotequal') {
				return $get($field->rule_field) != $field->rule_value;
			} else {
				return false;
			}
		}
	}

	private static function getBladeTemplates($record, bool $default = false): array
	{

		if ($default || empty($record)) {

			$fileArray = ['default' => 'default'];

		} else {

			$themepath = config('theme.active');
			$widgetpath = 'laracms/themes/' . $themepath . '/views/_widgets/lara/';

			$fileArray = array();

			if ($record->type == 'module') {

				$bladepath = $widgetpath . 'entity';
				$files = Storage::disk('lara')->files($bladepath);

				foreach ($files as $file) {
					$filename = basename($file);
					$pos = strrpos($filename, '.blade.php');
					if ($pos !== false) {
						$tname = substr($filename, 0, $pos);
						if (str_ends_with($tname, $record->resource_slug)) {
							// $val = substr($tname, 0, strlen($tname) - strlen($record->resource_slug) - 1);
							$fileArray[$tname] = $tname;
						}
					}
				}

			} else {

				$bladepath = $widgetpath . 'text';
				$files = Storage::disk('lara')->files($bladepath);

				foreach ($files as $file) {
					$filename = basename($file);
					$pos = strrpos($filename, '.blade.php');
					if ($pos !== false) {
						$tname = substr($filename, 0, $pos);
						if (str_starts_with($tname, $record->type)) {
							$val = substr($tname, strlen($record->type) + 1);
							$fileArray[$val] = $val;
						}
					}
				}
			}
		}

		return $fileArray;

	}

}
