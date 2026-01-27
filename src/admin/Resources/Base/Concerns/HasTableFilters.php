<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Cache;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Lara\Common\Models\User;

trait HasTableFilters
{
	private static function getBaseTableFilters(): array
	{

		$filters = array();

		// filter by group
		if (static::getEntity()->objrel_has_groups && static::getEntity()->filter_by_group) {
			$filters[] = SelectFilter::make('cgroup')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.cgroup'))
				->options(function () {
					$modelClass = static::getEntity()->model_class;

					return $modelClass::select('cgroup')->distinct()->langIs(static::$clanguage)->pluck('cgroup', 'cgroup')->toArray();
				})
				->default(fn() => (static::getSlug() == 'pages') ? 'page' : null);
		}

		// filter by relation
		foreach (static::getEntityRelationFilters() as $filter) {
			$filters[] = SelectFilter::make($filter->foreign_key)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.' . $filter->foreign_key))
				->options(function () use ($filter) {
					$relatedModelClass = $filter->relatedEntity->model_class;

					return $relatedModelClass::langIs(static::$clanguage)->pluck('title', 'id')->toArray();
				});
		}

		// filter by status
		if (static::getEntity()->show_status && static::getEntity()->filter_by_status) {
			$filters[] = SelectFilter::make('publish')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.publish'))
				->options(function () {
					return [
						1 => 'published',
						0 => 'draft',
					];
				});
		}

		// filter by category
		if (static::getEntity()->objrel_has_terms) {

			if (static::getEntity()->filter_by_category) {
				$filters[] = SelectFilter::make('categories')
					->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.categories'))
					->relationship(
						name: 'categories',
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
						}
					);

			}

			if (static::getEntity()->filter_by_tag) {
				$filters[] = SelectFilter::make('tags')
					->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.tags'))
					->relationship(
						name: 'tags',
						titleAttribute: 'title',
						modifyQueryUsing: function ($query) {
							return $query->where('language', static::$clanguage)->where('resource_slug', static::getSlug());
						}
					);
			}

		}

		// filter by author
		if (static::getEntity()->show_author && static::getEntity()->filter_by_author) {
			$filters[] = SelectFilter::make('user_id')
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.author'))
				->options(function () {
					$modelClass = static::getEntity()->model_class;

					return User::whereIn('id', $modelClass::select('user_id')->distinct()->langIs(static::$clanguage)->pluck('user_id')->toArray())->pluck('name', 'id')->toArray();
				});
		}

		// filter by custom field
		foreach (static::getEntity()->customfields()->isFilter()->get() as $filter) {
			$filters[] = SelectFilter::make($filter->field_name)
				->label(_q(static::getModule() . '::' . static::getSlug() . '.filter.' . $filter->field_name))
				->options(function () use ($filter) {
					$modelClass = static::getEntity()->model_class;
					$fname = $filter->field_name;

					return $modelClass::select($fname)->distinct()->whereNotNull($fname)->whereNot($fname, '')->langIs(static::$clanguage)->pluck($fname, $fname)->toArray();
				});
		}

		if (static::getEntity()->filter_by_trashed) {
			$filters[] = TrashedFilter::make();
		}

		return $filters;
	}

	private static function getEntityRelationFilters()
	{
		$cacheKey = 'lara_entity_relation_filters_' . static::getSlug();

		return Cache::rememberForever($cacheKey, function () {
			return static::getEntity()->relations()->isFilter()->get();
		});

	}

}