<?php

namespace Lara\Admin\Resources\Entities\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;
use Lara\Admin\Concerns\HasLaraBuilder;
use Lara\Admin\Resources\Entities\EntityResource;

class CreateEntity extends CreateRecord
{
    use HasLaraBuilder;

    protected static string $resource = EntityResource::class;

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
            $this->getCreateFormAction()
                ->label(_q('lara-admin::default.action.save'))
                ->submit(null)
                ->action(fn () => $this->create()),
        ];
    }

    protected function afterCreate(): void
    {
        $entity = $this->getRecord();

        // on failure the entity row is removed again, so stay on the form to correct it
        if (! static::buildEntity($entity)) {
            $this->halt();
        }

        // refresh route cache
        session(['laracacheclear' => ['response_cache', 'route_cache']]);

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
