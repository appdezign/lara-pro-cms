<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Schema;
use Lara\Admin\Enums\LayoutSections;
use Lara\Common\Models\ObjectLayout;

trait HasLayoutSection
{
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
					if(property_exists($layout, $section)) {
						foreach ($layout->$section as $options) {
							$optionValue = $options->partialFile;
							$optionLabel = $options->friendlyName;
							if ($options->isDefault == 'true') {
								$sectionOptions[$optionValue] = $optionLabel . ' [default]';
							} else {
								$sectionOptions[$optionValue] = $optionLabel;
							}
						}
					}
					return $sectionOptions;
				})
				->placeholder('[default]');
		}

		return $rows;

	}

	private static function checkLayoutColumn($tablename, $column): void
	{

		if (!Schema::hasColumn($tablename, $column)) {
			Schema::table($tablename, function ($table) use ($column) {
				$table->string($column)->nullable();
			});
		}
	}

}