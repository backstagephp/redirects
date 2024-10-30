<?php

namespace Vormkracht10\FilamentRedirects\Resources\RedirectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Vormkracht10\Backstage\Resources\RedirectResource;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
