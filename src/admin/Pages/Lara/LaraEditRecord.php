<?php

namespace Lara\Admin\Pages\Lara;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Concerns\HasContainerGridLayout;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;
use Lara\Admin\Enums\LayoutSections;
use Lara\Admin\Traits\HasLayout;
use Lara\Admin\Traits\HasMedia;
use Lara\Common\Models\ObjectLayout;

use Lara\Common\Models\Entity;

use Spatie\Geocoder\Facades\Geocoder;

class LaraEditRecord extends EditRecord
{

	use UsesResourceLock;
	use HasContainerGridLayout;
	use HasLayout;
	use HasMedia;

	public function getTitle(): string|Htmlable
	{

		return $this->record->title ?? parent::getTitle();
	}

	protected function mutateFormDataBeforeSave(array $data): array
	{

		if (array_key_exists('_body', $data)) {
			$data['body'] = $data['_body'];
		}

		if (array_key_exists('publish_expire', $data)) {
			if ($data['publish_expire'] == 0) {
				if (array_key_exists('publish_to', $data)) {
					$data['publish_to'] = null;
				}

			}
		}

		if (array_key_exists('is_global', $data)) {
			if ($data['is_global'] === true) {
				$this->record->onpages()->sync([]);
			}
		}

		if (array_key_exists('geo_location', $data)) {
			if ($data['geo_location'] === 'auto') {
				if (empty($data['geo_latitude']) || $data['geo_latitude'] == 0 || empty($data['geo_longitude']) || $data['geo_longitude'] == 0) {

					// check address
					if (!empty($data['geo_address']) && !empty($data['geo_pcode']) && !empty($data['geo_city']) && !empty($data['geo_country'])) {

						$geoAddress = $data['geo_address'] . ', ' . $data['geo_pcode'] . ', ' . $data['geo_city'] . ', ' . $data['geo_country'];

						// Get GEO Coordinates from Google API
						$geo = Geocoder::getCoordinatesForAddress($geoAddress);

						// Save coordinates
						if (!empty($geo['lat']) && !empty($geo['lng'])) {
							$data['geo_latitude'] = $geo['lat'];
							$data['geo_longitude'] = $geo['lng'];
						}

					}
				}
			}
		}

		return $data;
	}

	protected function afterSave(): void
	{

		if ($this->record->geo_location && $this->record->geo_location == 'auto') {
			$this->fillForm();
		}

		// save the image count, so we can use it in the tables
		static::saveImageCount($this->record);

		// replace default layout values with null
		static::replaceDefaultLayoutValues($this->record);

	}

	public function getFormActions(): array
	{
		return [];
	}

	protected function getHeaderActions(): array
	{

		$rows = array();

		$rows[] = Action::make('backtoindex')
			->url(static::getResource()::getUrl())
			->icon('heroicon-o-chevron-left')
			->iconButton()
			->color('gray');

		$rows[] = Action::make('save')
			->label(_q('lara-admin::default.action.save'))
			->color('danger')
			->submit(null)
			->action(function () {
				$this->save();
				$this->refreshFormData(['slug']);
			})
			->extraAttributes(['class' => 'mx-4 js-lara-save-button']);

		$previewRoute = static::getPreviewRoute($this->record, static::getResource());
		if($previewRoute) {
			$rows[] = Action::make('preview')
				->url(route($previewRoute, $this->record->id), true)
				->icon('heroicon-o-arrow-top-right-on-square')
				->iconButton()
				->color('gray');
		}

		return $rows;

	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.focus-mode', [
				'livewire'        => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}

	private static function getPreviewRoute($record, $resource): ?string
	{
		$resourceSlug = $resource::getSlug();
		$entity = $resource::getEntity();
		$checkview = $entity->views()->where('method', 'show')->first();
		if ($checkview) {
			$prefix = ($entity->objrel_has_terms == 1) ? 'contenttag.' : 'content.';
			$method = ($resourceSlug != 'pages') ? '.index.show' : '.show';

			return $prefix . $resourceSlug . $method;
		} else {
			return null;
		}
	}

}
