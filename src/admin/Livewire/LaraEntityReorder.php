<?php

namespace Lara\Admin\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Lara\Admin\Concerns\HasLanguage;
use Lara\Admin\Concerns\HasParams;
use Lara\Admin\Concerns\HasReorder;
use Lara\Common\Models\Entity;
use Livewire\Component;

class LaraEntityReorder extends Component
{
    use HasLanguage;
    use HasParams;
    use HasReorder;

    protected static ?string $clanguage = null;

    public string $model;

    public array $data = [];

    public function mount(string $resourceSlug): void
    {
        $entity = Entity::where('resource_slug', $resourceSlug)->first();
        $this->model = $entity->model_class;
    }

    public function render()
    {
        return view('lara-admin::livewire.lara-entity-reorder', [
            'items' => $this->items(),
        ]);
    }

    public function items(): Collection
    {
        static::setContentLanguage();

        return $this->model::langIs(static::$clanguage)->where('publish', 1)->orderBy('position')->get();
    }

    public function save(): void
    {
        if (empty($this->data)) {
            return;
        }

        static::setContentLanguage();

        static::saveEntityOrder(static::$clanguage, $this->model, $this->data);

        Notification::make()
            ->title(_q('lara-admin::default.message.reorder_saved'))
            ->success()
            ->send();
    }
}
