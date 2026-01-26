<?php

namespace Lara\Admin\Resources\Base\Schemas;

use Cache;
use Carbon\Carbon;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasAuthorSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasContentSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasGroupSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasLanguageSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasLayoutSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasOnPagesSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasOpenGraphSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasRelatedSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasSeoSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasStatusSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasSyncSection;
use Lara\Admin\Resources\Base\Schemas\Concerns\HasTagSection;


trait LaraBaseForm
{

	use HasAuthorSection;
	use HasContentSection;
	use HasGroupSection;
	use HasOpenGraphSection;
	use HasLanguageSection;
	use HasLayoutSection;
	use HasOnPagesSection;
	use HasRelatedSection;
	use HasSeoSection;
	use HasStatusSection;
	use HasSyncSection;
	use HasTagSection;

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
						->columnSpanFull()
						->collapsible()
						->schema(static::getMainImageSection())
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
				->schema(static::getOpenGraphSection())
				->visible(fn(string $operation) => $operation === 'edit');
		}

		if (static::resourceShowOpengraph()) {
			$sections[] = Section::make(_q('lara-admin::default.section.opengraph_advanced', true))
				->relationship('opengraph')
				->collapsible()
				->collapsed()
				->schema(static::getOpenGraphAdvancedSection())
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

}
