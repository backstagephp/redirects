<?php

namespace Vormkracht10\FilamentRedirects\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Vormkracht10\Redirects\Models\Redirect;

class RedirectImporter extends Importer
{
    protected static ?string $model = Redirect::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('site_ulid')
                ->label(__('Site'))
                ->requiredMapping()
                ->guess(['site', 'site_ulid']),
            ImportColumn::make('language_code')
                ->label(__('Language Code'))
                ->requiredMapping()
                ->guess(['language', 'language_code']),
            ImportColumn::make('country_code')
                ->label(__('Country Code'))
                ->guess(['KvKnr']),
            ImportColumn::make('content_ulid')
                ->label(__('Content'))
                ->requiredMapping()
                ->guess(['content', 'content_ulid']),
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
            ImportColumn::make('hits')
                ->requiredMapping()
                ->guess(['hits']),
        ];
    }

    public function resolveRecord(): ?Redirect
    {
        if (isset($this->data['source'])) {
            return Redirect::firstOrNew([
                'source' => $this->data['source'],
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
