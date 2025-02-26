<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Pages;

use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\ActionSize;
use Backstage\Redirects\Filament\Imports\RedirectImporter;
use Backstage\Redirects\Filament\Resources\RedirectResource;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\Action::make('import-paste')
                    ->label(__('Import by pasting text'))
                    ->icon('heroicon-o-clipboard-document-list')
                    ->modal()
                    ->modalWidth('100%')
                    ->form([
                        Grid::make([
                            'default' => 12,
                        ])->schema([
                            Select::make('code')
                                ->label(__('Type'))
                                ->columnSpanFull()
                                ->options(collect(config('redirects.status_codes'))->map(fn (string $type, int $code) => $code . ' ' . $type))
                                ->default(config('redirects.default_status_code'))
                                ->prefixIcon('heroicon-o-map-pin')
                                ->placeholder('HTTP status message')
                                ->required(),
                            Textarea::make('sources')
                                ->label(__('Sources'))
                                ->placeholder(__('Paste your source URLs here'))
                                ->columnSpan(6)
                                ->required()
                                ->rows(30),
                            Textarea::make('destinations')
                                ->label(__('Destinations'))
                                ->placeholder(__('Paste your destination URLs here'))
                                ->columnSpan(6)
                                ->required()
                                ->rows(30),
                        ]),
                    ]),
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
