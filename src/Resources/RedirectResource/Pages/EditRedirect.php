<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Pages;

use Backstage\Redirects\Filament\FilamentRedirects\Resources\RedirectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
