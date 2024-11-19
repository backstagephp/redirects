<?php

namespace Vormkracht10\FilamentRedirects\Resources\RedirectResource\Pages;

use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\ActionSize;
use Vormkracht10\FilamentRedirects\Imports\RedirectImporter;
use Vormkracht10\FilamentRedirects\Resources\RedirectResource;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\Action::make('import-paste')
                    ->label(__('Import by pasting text'))
                    ->icon('heroicon-o-clipboard-document-list'),
                Actions\ImportAction::make('import-file')
                    ->label(__('Import by file'))
                    ->icon('heroicon-o-arrow-up-on-square-stack')
                    ->importer(RedirectImporter::class),
            ])->label(__('Import'))
                ->color('gray')
                ->icon('heroicon-o-arrow-up-tray')
                ->size(ActionSize::Small)
                ->button(),
            Actions\CreateAction::make(),
        ];
    }
}
