<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Pages;

use Backstage\Redirects\Filament\Resources\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
