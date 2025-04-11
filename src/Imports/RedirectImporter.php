<?php

namespace Backstage\Redirects\Filament\Imports;

use Backstage\Redirects\Laravel\Models\Redirect;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class RedirectImporter extends Importer
{
    protected static ?string $model = Redirect::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('source')
                ->requiredMapping()
                ->label(__('Source'))
                ->guess(['source']),
            ImportColumn::make('destination')
                ->requiredMapping()
                ->label(__('Destination'))
                ->guess(['destination']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->rules(['max:3'])
                ->guess(['code', 'status', 'status_code']),
        ];
    }

    public function resolveRecord(): ?Redirect
    {
        if (isset($this->data['source'])) {
            return Redirect::firstOrNew([
                'source' => $this->data['source'],
                'site_id' => Filament::getTenant()->ulid,
            ]);
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = __('Your redirects import has completed and :numbers :row imported.', [
            'numbers' => number_format($import->successful_rows),
            'row' => str('row')->plural($import->successful_rows),
        ]);

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= __(' :numbers :row failed to import.', [
                'numbers' => number_format($failedRowsCount),
                'row' => str('row')->plural($failedRowsCount),
            ]);
        }

        return $body;
    }
}
