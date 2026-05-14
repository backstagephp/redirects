<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->badge()
                    ->width(0)
                    ->searchable()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        '301' => 'info',
                        '302' => 'gray',
                        '307' => 'warning',
                        '308' => 'info',
                    }),
                TextColumn::make('source')
                    ->width('50%')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hits')
                    ->searchable()
                    ->sortable()
                    ->alignRight()
                    ->formatStateUsing(fn (string $state): string => $state . ' ×')
                    ->width(50),
                TextColumn::make('destination')
                    ->width('50%')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
