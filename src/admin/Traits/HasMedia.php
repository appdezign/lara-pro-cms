<?php

namespace Lara\Admin\Traits;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
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
use Lara\Common\Models\objectImage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait HasMedia
{

	private static function getMainImageSection(): array
	{

		$rows = array();

		foreach (ImageHooks::cases() as $hook) {

			$entityMediaFieldSetting = $hook->getEntityField();
			if (static::getEntity()->$entityMediaFieldSetting) {

				$rows[] = CuratorPicker::make($hook->value . '_ids')
					->label($hook->value)
					->multiple()
					->maxItems(1)
					->directory(static::getSlug())
					->relationship('images', 'id')
					->orderColumn('order')
					->typeColumn('type')
					->typeValue($hook->value);

			}
		}

		if (static::resourceHasGallery()) {

			$rows[] = CuratorPicker::make('gallery_ids')
				->label('gallery')
				->multiple()
				->maxItems(static::getMaxGallery())
				->directory(static::getSlug())
				->relationship('images', 'id')
				->orderColumn('order')
				->typeColumn('type')
				->typeValue('gallery');

		}

		return $rows;
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
					->disk(static::getDiskForFiles())
					->directory(static::getSlug() . '/file')
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
					->disk(static::getDiskForVideos())
					->directory(static::getSlug() . '/video')
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

	private static function lockMediaItems($record)
	{
		if ($record->hasFeatured()) {
			static::lockMedia($record->featured());
		}
		if ($record->hasThumb()) {
			static::lockMedia($record->thumb());
		}
		if ($record->hasHero()) {
			static::lockMedia($record->hero());
		}
		if ($record->hasIcon()) {
			static::lockMedia($record->icon());
		}
		if ($record->HasGallery()) {
			$gallery = $record->gallery();
			foreach ($gallery as $item) {
				static::lockMedia($item);
			}
		}

	}

	private static function syncFullMediaLibrary()
	{

		$dateFormat = 'Y-m-d H:i:s';
		$syncInterval = config('lara-admin.lara-media.sync-interval', 60); // seconds
		if (session()->has('laracms.media.sync')) {
			$lastSyncStr = session()->get('laracms.media.sync');
			$lastSync = Carbon::createFromFormat($dateFormat, $lastSyncStr);
			if ($lastSync->diffInSeconds(Carbon::now()) < $syncInterval) {
				return false;
			}
		}

		// reset
		$media = Media::all();
		foreach ($media as $item) {
			static::unlockMedia($item);
		}

		// sync
		$images = objectImage::all();
		foreach ($images as $image) {
			static::lockMedia($image->media);
		}

		session()->put('laracms.media.sync', date($dateFormat));

		return true;
	}

	private static function lockMedia($media)
	{
		if (!empty($media) && $media instanceof Media) {
			$media->in_use = 1;
			$media->save();
		}
	}

	private static function unlockMedia($media)
	{
		if (!empty($media) && $media instanceof Media) {
			$media->in_use = 0;
			$media->save();
		}
	}

}
