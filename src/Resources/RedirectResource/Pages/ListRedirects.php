<?php

namespace Vormkracht10\FilamentRedirects\Resources\RedirectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Vormkracht10\FilamentRedirects\Imports\RedirectImporter;
use Vormkracht10\FilamentRedirects\Resources\RedirectResource;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->label(__('Import'))
                ->importer(RedirectImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
