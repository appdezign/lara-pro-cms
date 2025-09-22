<?php

namespace Lara\Admin\Resources\Roles\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Lara\Admin\Enums\LaraPermissions;
use Lara\Admin\Resources\Roles\RoleResource;

use Lara\Admin\Resources\Roles\Concerns\HasPermissions;

class EditRole extends EditRecord
{

	use HasPermissions;

    protected static string $resource = RoleResource::class;

    public function getTitle(): string | Htmlable
    {
        $entity = $this->getRecord();
        return $entity->name;
    }

    public function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backtoindex')
                ->url(static::getResource()::getUrl())
                ->icon('heroicon-o-chevron-left')
                ->iconButton()
                ->color('gray'),
	        Action::make('save')
		        ->label('save')
		        ->color('danger')
		        ->submit(null)
		        ->action(function() {
			        $this->save();
		        }),
        ];
    }

	protected function mutateFormDataBeforeFill(array $data): array
	{
		$role = $this->getRecord();
		$rolePermissions = $role->permissions()->pluck('name')->toArray();

		$policyModels = static::getPoliciesFromGate();
		foreach ($policyModels as $modelName) {
			$entityPermissions = array();
			foreach (LaraPermissions::cases() as $permission) {
				$modelPermission = $permission->value . '_' . $modelName;
				if(in_array($modelPermission, $rolePermissions)) {
					$entityPermissions[] = $modelPermission;
				}
			}
			$data[$modelName] = $entityPermissions;
		}

		$customPermissions = config('lara.filament.custom_page_permissions');
		foreach ($customPermissions as $page => $pagePermissions) {
			$customPermissions = array();
			foreach ($pagePermissions as $pagePermission) {
				if(in_array($pagePermission, $rolePermissions)) {
					$customPermissions[] = $pagePermission;
				}
			}
			$data[$page] = $customPermissions;
		}

		return $data;
	}

	protected function mutateFormDataBeforeSave(array $data): array
	{
		$permissions = array();

		$policyModels = static::getPoliciesFromGate();
		foreach ($policyModels as $modelName) {
			if(array_key_exists($modelName, $data)) {
				$entityPermissions = $data[$modelName];
				$permissions = array_merge($entityPermissions, $permissions);
			}
		}

		$customPermissions = config('lara.filament.custom_page_permissions');
		foreach ($customPermissions as $page => $pagePermissions) {
			$customPermissions = $data[$page];
			$permissions = array_merge($customPermissions, $permissions);
		}

		$role = $this->getRecord();
		$role->syncPermissions($permissions);
		return $data;
	}

	public function render(): View
	{
		return view($this->getView(), $this->getViewData())
			->layout('lara-admin::layout.focus-mode', [
				'livewire' => $this,
				'maxContentWidth' => $this->getMaxContentWidth(),
				...$this->getLayoutData(),
			]);
	}

}
