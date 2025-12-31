<?php

namespace Lara\Admin\Resources\Media\Tables;

use Filament\Tables\Table;
use Awcodes\Curator\Resources\Media\Tables\MediaTable as BaseMediaTable;


class MediaTable extends BaseMediaTable
{
    /** @throws Exception */
    public static function configure(Table $table): Table
    {

		dd('lara table');
        $livewire = $table->getLivewire();

        return $table
            ->columns(
                $livewire->layoutView === 'grid'
                    ? static::getDefaultGridTableColumns()
                    : static::getDefaultTableColumns(),
            )
            ->searchable(['title', 'caption', 'description'])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->contentGrid(function () use ($livewire): ?array {
                if ($livewire->layoutView === 'grid') {
                    return [
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 4,
                    ];
                }

                return null;
            })
            ->defaultPaginationPageOption(12)
            ->paginationPageOptions([6, 12, 24, 48, 'all'])
            ->recordUrl(null);
    }

}
