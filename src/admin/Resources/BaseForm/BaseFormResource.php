<?php

namespace Lara\Admin\Resources\BaseForm;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

use Lara\Admin\Resources\Base\BaseResource;
use Lara\Admin\Resources\BaseForm\Concerns\HasBaseForm;
use Lara\Admin\Resources\BaseForm\Concerns\HasBaseTable;

/**
 * Base resource for form entities (contact forms and the like).
 *
 * A form resource is a content resource whose records are submissions: they are
 * listed and viewed, never created or edited in the panel. Everything it shares
 * with BaseResource - labels, navigation, policy, language handling, the
 * trashed-records query - is inherited.
 *
 * The two HasBase* traits below are the BaseForm variants, which take
 * precedence over the ones BaseResource mixes in. Only the pieces that genuinely
 * differ are overridden here.
 */
class BaseFormResource extends BaseResource
{

	use HasBaseForm;
	use HasBaseTable;

	/**
	 * Form submissions are not reorderable, so the tabs need no per-record key.
	 */
	public static function form(Schema $schema): Schema
	{
		return $schema
			->components([
				Tabs::make('Tabs')
					->tabs(static::getLaraFormTabs())
					->columnSpanFull()
					->persistTab()
					->id(static::getSlug() . '-tab'),
			]);
	}

	/**
	 * As BaseResource::table(), without deferred loading or a default sort:
	 * submissions are listed in their natural order.
	 */
	public static function table(Table $table): Table
	{
		static::setContentLanguage();

		$filterLayout = static::getEntity()->filter_is_open
			? FiltersLayout::AboveContent
			: FiltersLayout::AboveContentCollapsible;

		return $table
			->columns(static::getBaseTableColumns())
			->filters(static::getBaseTableFilters(), layout: $filterLayout)
			->deferFilters(false)
			->persistFiltersInSession()
			->deferColumnManager(false)
			->actions(static::getBaseTableActions())
			->bulkActions(static::getBaseTableBulkActions())
			->modifyQueryUsing(fn(Builder $query) => static::getBaseQuery($query));
	}

}
