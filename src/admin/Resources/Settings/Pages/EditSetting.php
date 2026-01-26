<?php

namespace Lara\Admin\Resources\Settings\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Lara\Admin\Resources\Settings\SettingResource;
use Lara\Admin\Traits\HasLocks;

class EditSetting extends EditRecord
{

	use HasLocks;

    protected static string $resource = SettingResource::class;

	public function mount(int|string $record): void
	{
		parent::mount($record);
		static::checkRecordLock($this->record);
		static::lockRecord($this->record);
	}

    public function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
	        Action::make('unlockrecord')
		        ->icon('bi-chevron-left')
		        ->iconButton()
		        ->color('gray')
		        ->action(function () {
			        static::unlockRecord($this->record);
			        return redirect()->route('filament.admin.resources.settings.index');
		        }),
	        Action::make('save')
		        ->label('save')
		        ->color('danger')
		        ->submit(null)
		        ->action(function() {
			        $this->save();
		        }),
        ];
    }


}
