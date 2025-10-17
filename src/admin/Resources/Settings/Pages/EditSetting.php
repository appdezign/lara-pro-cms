<?php

namespace Lara\Admin\Resources\Settings\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Lara\Admin\Resources\Settings\SettingResource;

class EditSetting extends EditRecord
{

    protected static string $resource = SettingResource::class;

    public function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backtoindex')
                ->url(static::getResource()::getUrl())
                ->icon('bi-chevron-left')
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


}
