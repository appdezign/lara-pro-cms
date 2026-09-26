<?php

namespace Lara\Admin\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Lara\Admin\Concerns\HasCache;
use Lara\Admin\Concerns\HasLaraBuilder;
use Lara\Common\Models\Entity;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * The backup columns of an entity, shown under its custom fields.
 *
 * When a field is deleted, renamed or changes type, the builder keeps the old column as
 * "_fieldname". Webmasters have no database access, so this is where they restore such a
 * column as a field again, with its data, or delete it permanently.
 */
class BackupColumns extends Component implements HasActions, HasSchemas, HasTable
{
	use HasCache;
	use HasLaraBuilder;
	use InteractsWithActions;
	use InteractsWithSchemas;
	use InteractsWithTable;

	public Entity $entity;

	/**
	 * A field was deleted, renamed or changed type, so a backup may have appeared.
	 */
	#[On('lara-backup-columns-changed')]
	public function refreshBackupColumns(): void
	{
		$this->resetTable();
	}

	public function table(Table $table): Table
	{
		return $table
			->heading('Backup columns')
			->description('Columns kept after a field was deleted, renamed or changed type. Restore one to turn it back into a field with its data, or delete it permanently.')
			->records(fn (): array => static::getBackupColumns($this->entity))
			->columns([
				TextColumn::make('columns')
					->label('Column')
					->state(fn (array $record): string => implode(', ', $record['columns'])),
				TextColumn::make('column_type')
					->label('Type'),
				TextColumn::make('filled_rows')
					->label('Rows with data'),
			])
			->recordActions([
				Action::make('restore')
					->label('Restore')
					->icon('bi-arrow-counterclockwise')
					->visible(fn (): bool => $this->canManageBackupColumns())
					->disabled(fn (array $record): bool => static::getRestorableFieldTypes($this->entity, $record) === [])
					->modalHeading(fn (array $record): string => 'Restore '.implode(', ', $record['columns']).' as a field')
					->schema(fn (array $record): array => [
						TextInput::make('title')
							->label('Title')
							->default(Str::headline($record['key']))
							->maxLength(255)
							->required(),
						Select::make('field_type')
							->label('Field type')
							->options(static::getRestorableFieldTypes($this->entity, $record))
							->default(array_key_first(static::getRestorableFieldTypes($this->entity, $record)))
							->required(),
					])
					->action(function (array $record, array $data): void {
						if (static::restoreBackupColumn($this->entity, $record['key'], $data['field_type'], $data['title'])) {
							static::clearCacheTypes();
							$this->dispatch('lara-custom-fields-changed');
						}

						$this->resetTable();
					}),
				Action::make('delete')
					->label('Delete')
					->icon('bi-trash')
					->color('danger')
					->visible(fn (): bool => $this->canManageBackupColumns())
					->requiresConfirmation()
					->modalHeading(fn (array $record): string => 'Delete '.implode(', ', $record['columns']).' permanently?')
					->modalDescription(fn (array $record): string => $record['filled_rows'].' rows contain data in this column. That data cannot be restored after deleting it.')
					->modalSubmitActionLabel('Delete permanently')
					->action(function (array $record): void {
						static::dropBackupColumn($this->entity, $record['key']);

						$this->resetTable();
					}),
			])
			->emptyStateHeading('No backup columns')
			->emptyStateDescription('When a field is deleted, renamed or changes type, its previous column is kept here.')
			->paginated(false);
	}

	private function canManageBackupColumns(): bool
	{
		return auth()->user()?->can('update', $this->entity) ?? false;
	}

	public function render(): View
	{
		return view('lara-admin::livewire.backup-columns');
	}
}
