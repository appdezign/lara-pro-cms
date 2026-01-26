<?php

namespace Lara\Admin\Resources\Users\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Lara\Admin\Resources\Users\UserResource;
use Lara\Admin\Traits\HasLocks;

class EditUser extends EditRecord
{
	use HasLocks;

    protected static string $resource = UserResource::class;

	public function mount(int|string $record): void
	{
		parent::mount($record);
		static::checkRecordLock($this->record);
		static::lockRecord($this->record);
	}

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
	        Action::make('unlockrecord')
		        ->icon('bi-chevron-left')
		        ->iconButton()
		        ->color('gray')
		        ->action(function () {
			        static::unlockRecord($this->record);
			        return redirect()->route('filament.admin.resources.users.index');
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
