<?php

namespace Lara\Admin\Traits;

use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Lara\Admin\Components\YouTubeField;
use Lara\Admin\Enums\ImageHooks;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait HasMedia
{

	private static function getMainImageSection(): array
	{

		$rows = array();

		foreach (ImageHooks::cases() as $hook) {

			$entityMediaFieldSetting = $hook->getEntityField();
			if (static::getEntity()->$entityMediaFieldSetting) {

				$rows[] = Repeater::make($hook->value)
					->label(new HtmlString('<h3>' . ucfirst($hook->value) . '</h3>'))
					->columnSpanFull()
					->columns([
						'sm' => 2,
						'lg' => 3,
						'xl' => 4,
					])
					->addActionLabel(_q('lara-admin::default.button.repeater_add'))
					->addActionAlignment(Alignment::Start)
					->schema([
						FileUpload::make($hook->value . '_filename')
							->hiddenLabel()
							->live()
							->required()
							->itemPanelAspectRatio('0.75')
							->panelAspectRatio('4:3')
							->disk(config('lara.uploads.disk'))
							->directory(static::getSlug())
							->imageResizeMode('contain')
							->imageResizeTargetWidth(config('lara.uploads.images.max_width'))
							->imageResizeTargetHeight(config('lara.uploads.images.max_height'))
							->visibility('public')
							->storeFileNamesIn($hook->value . '_original')
							->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => static::cleanupFilename($file))
							->extraAttributes(['class' => 'lara-file-upload']),
						Group::make([
							TextInput::make($hook->value . '_original')
								->label(_q('lara-admin::default.fileupload.original'))
								->readonly(true),
							TextInput::make($hook->value . '_seo_alt')
								->label(_q('lara-admin::default.fileupload.seo_alt')),
							TextInput::make($hook->value . '_seo_title')
								->label(_q('lara-admin::default.fileupload.seo_title')),
							TextInput::make($hook->value . '_caption')
								->label(_q('lara-admin::default.fileupload.caption')),
							Toggle::make($hook->value . '_prevent_cropping')
								->label(_q('lara-admin::default.fileupload.prevent_cropping'))
								->visible($hook->value == 'featured'),
							Select::make($hook->value . '_hero_size')
								->label(_q('lara-admin::default.fileupload.hero_size'))
								->options([
									0 => 'small',
									1 => 'medium',
									2 => 'large',
									3 => 'xl',
									4 => 'xxl',
									5 => 'xxxl',
								])
								->visible($hook->value == 'hero'),
						])
							->columnSpan([
								'sm' => 1,
								'lg' => 2,
								'xl' => 2,
							])->columnStart([
								'sm' => 0,
								'lg' => 0,
								'xl' => 3,
							])->visible(fn(Get $get) => !empty($get($hook->value . '_filename'))),

					])
					->maxItems(1)
					->defaultItems(0)
					->extraAttributes(['class' => 'lara-media-section hide-media-sort']);
			}
		}

		if (static::resourceHasGallery()) {

			$rows[] = FileUpload::make('gallery_upload')
				->label(function (Get $get) {
					return new HtmlString('<h3>' . _q('lara-admin::default.section.gallery', true) . '</h3><p class="fi-section-header-description mb-4">(' . sizeof($get('gallery')) . '/' . static::getMaxGallery() . ')</p>');
				})
				->columnSpanFull()
				->panelLayout('grid')
				->itemPanelAspectRatio('0.75')
				->multiple()
				->maxFiles(static::getMaxGallery())
				->reorderable()
				->disk(config('lara.uploads.disk'))
				->directory(static::getSlug())
				->imageResizeMode('contain')
				->imageResizeTargetWidth(config('lara.uploads.images.max_width'))
				->imageResizeTargetHeight(config('lara.uploads.images.max_height'))
				->visibility('public')
				->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => static::cleanupFilename($file))
				->disabled(fn (Get $get) => sizeof($get('gallery')) >= static::getMaxGallery());

			$rows[] = Repeater::make('gallery')
				->hiddenLabel()
				->columnSpanFull()
				->columns([
					'sm' => 2,
					'lg' => 3,
					'xl' => 4,
				])
				->addActionLabel(_q('lara-admin::default.button.repeater_add'))
				->addActionAlignment(Alignment::Start)
				->live()
				->defaultItems(0)
				->maxItems(static::getMaxGallery())
				->schema([

					FileUpload::make('gallery_filename')
						->hiddenLabel()
						->live()
						->panelAspectRatio('4:3')
						->itemPanelAspectRatio('0.75')
						->disk(config('lara.uploads.disk'))
						->directory(static::getSlug())
						->imageResizeMode('contain')
						->imageResizeTargetWidth(config('lara.uploads.images.max_width'))
						->imageResizeTargetHeight(config('lara.uploads.images.max_height'))
						->visibility('public')
						->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => static::cleanupFilename($file))
						->storeFileNamesIn('gallery_original'),

					Group::make([
						TextInput::make('gallery_original')
							->label(_q('lara-admin::default.fileupload.original'))
							->readonly(true)
							->visible(fn($state) => !empty($state)),
						TextInput::make('gallery_seo_alt')
							->label(_q('lara-admin::default.fileupload.seo_alt')),
						TextInput::make('gallery_seo_title')
							->label(_q('lara-admin::default.fileupload.seo_title')),
						TextInput::make('gallery_caption')
							->label(_q('lara-admin::default.fileupload.caption')),

					])->columnSpan([
						'sm' => 1,
						'lg' => 2,
						'xl' => 2,
					])->columnStart([
						'sm' => 0,
						'lg' => 0,
						'xl' => 3,
					])->visible(fn(Get $get) => !empty($get('gallery_filename'))),
				])->extraAttributes(['class' => 'lara-gallery-section']);

		}

		return $rows;
	}

	private static function mutateGalleryData($data): array
	{

		if (static::resourceHasGallery()) {
			if (array_key_exists('gallery_upload', $data) && array_key_exists('gallery', $data)) {
				$galleryPro = $data['gallery'];

				foreach ($data['gallery_upload'] as $imageFileName) {

					$imageArray = [
						'gallery_filename'  => $imageFileName,
						'gallery_original'  => static::getOriginalFilename($imageFileName),
						'gallery_seo_alt'   => null,
						'gallery_seo_title' => null,
						'gallery_caption'   => null,
					];

					$galleryPro[] = $imageArray;

				}
				$data['gallery'] = $galleryPro;
				$data['gallery_upload'] = [];
			}
		}

		return $data;
	}

	private static function getOriginalFilename($imageFileName): string
	{
		$pos = strpos($imageFileName, '-');
		if ($pos !== false) {
			$originalFilename = substr($imageFileName, $pos + 1);
		} else {
			$originalFilename = $imageFileName;
		}

		return $originalFilename;

	}

	private static function getFilesSection(): array
	{
		$rows = array();

		$rows[] = Repeater::make('entity_files')
			->label(_q('lara-admin::default.repeater.files', true))
			->columnSpanFull()
			->columns([
				'sm' => 2,
				'lg' => 3,
				'xl' => 4,
			])
			->addActionLabel(_q('lara-admin::default.button.repeater_add'))
			->addActionAlignment(Alignment::Start)
			->schema([
				FileUpload::make('doc_filename')
					->hiddenLabel()
					->live()
					->required()
					->acceptedFileTypes(config('lara.uploads.accepted_file_types'))
					->previewable(true)
					->itemPanelAspectRatio('0.75')
					->directory(static::getSlug())
					->storeFileNamesIn('doc_original')
					->visibility('public')
					->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => static::cleanupFilename($file))
					->extraAttributes(['class' => 'lara-file-upload']),
				Group::make([
					TextInput::make('doc_original')
						->label(_q('lara-admin::default.repeaterfield.doc_original', true)),
					DateTimePicker::make('doc_date')
						->label(_q('lara-admin::default.repeaterfield.doc_date', true))
						->default(Carbon::now()),
				])->columnSpan([
					'sm' => 1,
					'lg' => 2,
					'xl' => 2,
				])->columnStart([
					'sm' => 0,
					'lg' => 0,
					'xl' => 3,
				])->visible(fn(Get $get) => !empty($get('doc_filename'))),

			])
			->defaultItems(0)
			->maxItems(static::getMaxFiles())
			->columns(2)
			->extraAttributes(['class' => 'lara-files-section']);

		return $rows;

	}

	private static function getVideoSection(): array
	{
		$rows = array();

		$rows[] = Repeater::make('entity_videos')
			->label(_q('lara-admin::default.repeater.videos', true))
			->addActionLabel(_q('lara-admin::default.button.repeater_add'))
			->addActionAlignment(Alignment::Start)
			->schema([
				TextInput::make('video_title')
					->label(_q('lara-admin::default.repeaterfield.video_title', true))
					->columnSpanFull(),
				YouTubeField::make('youtubecode')
					->label(_q('lara-admin::default.repeaterfield.youtubecode', true))
					->required()
					->columnSpanFull(),
			])
			->defaultItems(0)
			->maxItems(static::getMaxVideos())
			->columns(2);

		return $rows;

	}

	private static function getVideoFilesSection(): array
	{
		$rows = array();

		$rows[] = Repeater::make('entity_videofiles')
			->label(_q('lara-admin::default.repeater.videofiles', true))
			->columnSpanFull()
			->columns([
				'sm' => 2,
				'lg' => 3,
				'xl' => 4,
			])
			->addActionLabel(_q('lara-admin::default.button.repeater_add'))
			->addActionAlignment(Alignment::Start)
			->schema([

				FileUpload::make('vidfile_filename')
					->hiddenLabel()
					->live()
					->required()
					->acceptedFileTypes(config('lara.uploads.accepted_videofile_types'))
					->previewable(true)
					->directory(static::getSlug())
					->visibility('public')
					->storeFileNamesIn('vidfile_original')
					->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => static::cleanupFilename($file))
					->extraAttributes(['class' => 'lara-file-upload']),
				Group::make([
					TextInput::make('vidfile_original')
						->label(_q('lara-admin::default.repeaterfield.vidfile_original', true)),
					DateTimePicker::make('vidfile_date')
						->label(_q('lara-admin::default.repeaterfield.vidfile_date', true))
						->default(Carbon::now()),
				])->columnSpan([
					'sm' => 1,
					'lg' => 2,
					'xl' => 2,
				])->columnStart([
					'sm' => 0,
					'lg' => 0,
					'xl' => 3,
				])->visible(fn(Get $get) => !empty($get('vidfile_filename'))),

			])
			->defaultItems(0)
			->maxItems(static::getMaxVideofiles())
			->columns(2);

		return $rows;

	}

	private static function cleanupFilename($file): string
	{
		$timestamp = date('YmdHis');
		$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
		$cleanFilename = Str::slug($filename);

		return $timestamp . '-' . $cleanFilename . '.' . $extension;;
	}

	private static function saveImageCount($record): void
	{
		$imageRecord = $record->images;

		if ($imageRecord) {
			$imageCount = 0;
			if ($record->hasFeatured()) {
				$imageCount++;
			}
			if ($record->hasThumb()) {
				$imageCount++;
			}
			if ($record->hasHero()) {
				$imageCount++;
			}
			if ($record->hasIcon()) {
				$imageCount++;
			}
			if ($record->hasGallery()) {
				$imageCount = $imageCount + count($record->getGallery());
			}
			$imageRecord->image_count = $imageCount;
			$imageRecord->save();
		}
	}

}
