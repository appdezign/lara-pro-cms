<?php

namespace Lara\Admin\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Lara\Admin\Enums\LaraPermissions;
use Lara\Admin\Resources\Roles\RoleResource;
use Lara\Common\Models\Entity;
use Spatie\Permission\Models\Permission;

class RoleForm
{
	private static function rs(): RoleResource
	{
		$class = RoleResource::class;
		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{
		static::checkEntityPermissions();

		return $schema
			->components(static::getRoleFormFields());
	}

	private static function getRoleFormFields(): array
	{
		$rows = array();
		$rows[] = Section::make('Content')
			->collapsible()
			->columnSpanFull()
			->schema([
				TextInput::make('name')
					->required(fn(string $operation) => $operation == 'create')
					->disabled(fn(string $operation) => $operation == 'edit')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.name')),
				Select::make('guard_name')
					->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.guard_name'))
					->options([
						'web' => 'web',
					])
					->selectablePlaceholder(false)
					->required(fn(string $operation) => $operation == 'create')
					->disabled(fn(string $operation) => $operation == 'edit'),
				Toggle::make('has_panel_access')
					->label(_q('lara-admin::default.column.has_panel_access'))
					->inlineLabel(true)

			]);


		$policyGroups = static::getPoliciesFromGate(true);

		// create sections for each entity group
		foreach ($policyGroups as $policyGroup => $modelNames) {
			$rows[] = Section::make($policyGroup)
				->collapsible()
				->columnSpanFull()
				->schema(static::getEntityPermissions($modelNames))
				->visible(fn(string $operation) => $operation == 'edit');

		}

		// custom pages
		$rows[] = Section::make('Custom')
			->collapsible()
			->columnSpanFull()
			->schema(static::getCustomPermissions())
			->visible(fn(string $operation) => $operation == 'edit');


		return $rows;
	}

	private static function getEntityPermissions($modelNames): array
	{
		$rows = array();
		foreach ($modelNames as $modelName) {
			$rows[] = Fieldset::make($modelName)
				->columns(1)
				->schema([
					CheckboxList::make($modelName)
						->hiddenLabel()
						->options(static::getPermissionOptions($modelName))
						->columns(6)
						->gridDirection('row')
						->bulkToggleable(),
				]);
		}
		return $rows;
	}

	private static function getPermissionOptions($modelName): array
	{
		$options = array();
		foreach (LaraPermissions::cases() as $permission) {
			$modelPermission = $permission->value . '_' . $modelName;
			$label = str_replace('_', ' ', $permission->value);
			$options[$modelPermission] = $label;
		}
		return $options;
	}

	private static function getCustomPermissions(): array
	{
		$rows = array();

		$customPermissions = config('lara.filament.custom_page_permissions');
		foreach ($customPermissions as $page => $pagePermissions) {
			$rows[] = Fieldset::make($page)
				->columns(1)
				->schema([
					CheckboxList::make($page)
						->hiddenLabel()
						->options(static::getCustomPermissionOptions($pagePermissions))
						->columns(6)
						->gridDirection('row')
						->bulkToggleable(),
				]);
		}
		return $rows;
	}

	private static function getCustomPermissionOptions($pagePermissions): array
	{
		$options = array();
		foreach ($pagePermissions as $pagePermission) {
			$label = str_replace('_', ' ', $pagePermission);
			$options[$pagePermission] = $label;
		}

		return $options;
	}

	private static function checkEntityPermissions(): void
	{

		$policyModels = static::getPoliciesFromGate();
		foreach ($policyModels as $modelName) {
			foreach (LaraPermissions::cases() as $permission) {
				$modelPermission = $permission->value . '_' . $modelName;
				Permission::firstOrCreate(
					['name' => $modelPermission],
					['guard_name' => 'web']
				);
			}
		}

		$customPermissions = config('lara.filament.custom_page_permissions');
		foreach ($customPermissions as $page => $pagePermissions) {
			foreach($pagePermissions as $pagePermission) {
				Permission::firstOrCreate(
					['name' => $pagePermission],
					['guard_name' => 'web']
				);
			}
		}

	}

	private static function getPoliciesFromGate(bool $group = false): array
	{

		$policies = array_keys(Gate::policies());

		if($group) {
			$cgroups = array();
			foreach ($policies as $model) {
				$labelSingle = strtolower(class_basename($model));
				$entity = Entity::where('label_single', $labelSingle)->first();
				if($entity) {
					$cgroups[$entity->cgroup][] = $labelSingle;
				} else {
					if(in_array($labelSingle, ['user', 'role'])) {
						$cgroups['auth'][] = $labelSingle;
					} else {
						$cgroups['system'][] = $labelSingle;
					}
				}
			}
			return $cgroups;
		} else {
			$modelNames = array();
			foreach ($policies as $model) {
				$labelSingle = strtolower(class_basename($model));
				$modelNames[] = $labelSingle;
			}
			return $modelNames;
		}
	}

}
