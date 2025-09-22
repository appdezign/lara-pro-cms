<?php

namespace Lara\Admin\Resources\Translations\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Lara\Admin\Resources\Translations\Concerns\HasTranslations;
use Lara\Admin\Resources\Translations\TranslationResource;
use Lara\Common\Models\Translation;

class ListTranslations extends ListRecords
{
	use HasTranslations;

	protected static string $resource = TranslationResource::class;

	public function mount(): void
	{
		parent::mount();

		// static::autoTranslateEnglishKeys();
		// static::cleanTranslationTable();
	}

	protected function getHeaderActions(): array
	{
		return [
			Action::make('cleanup_duplicates')
				->label(_q('lara-admin::translations.button.cleanup_duplicates'))
				->action(function () {
					static::cleanTranslationTable();

					return redirect(TranslationResource::getUrl());
				})
				->requiresConfirmation()
				->color('primary')
				->modalHeading('Cleanup duplicate entries'),

			Action::make('auto_translate_en')
				->label(_q('lara-admin::translations.button.auto_translate_en'))
				->action(function () {
					static::autoTranslateEnglishKeys();

					return redirect(TranslationResource::getUrl());
				})
				->requiresConfirmation()
				->color('primary')
				->modalHeading('Autotranslate English strings'),

			Action::make('export_to_file')
				->label(_q('lara-admin::translations.button.export_to_file'))
				->action(function () {
					static::exportToFile();

					return redirect(TranslationResource::getUrl());
				})
				->requiresConfirmation()
				->color('danger')
				->modalHeading('Export to file'),


		];
	}

	protected static function exportToFile(): void
	{

		$exportCount = static::exportTranslationsToFile();

		Notification::make()
			->title('Export complete')
			->body($exportCount . ' translations have been exported successfully')
			->success()
			->send();

	}

	private static function autoTranslateEnglishKeys(): void
	{
		$translations = Translation::where('language', 'en')->where(DB::raw("substring(value, 1, 1)"), '=', '_')->get();
		foreach ($translations as $translation) {
			$newValue = substr($translation->value, 1);
			$newValue = str_replace('_', ' ', $newValue);
			$translation->value = $newValue;
			$translation->save();
		}
	}

	private static function cleanTranslationTable(): void
	{
		$translations = Translation::orderBy('created_at', 'asc')->get();
		foreach ($translations as $translation) {
			$check = Translation::where('language', $translation->language)
				->where('module', $translation->module)
				->where('resource', $translation->resource)
				->where('tag', $translation->tag)
				->where('key', $translation->key)
				->whereNotIn('id', [$translation->id])
				->first();
			if ($check) {
				$check->delete();
			}
		}
	}

}
