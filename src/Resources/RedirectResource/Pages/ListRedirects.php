<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Pages;

use Backstage\Redirects\Filament\Imports\RedirectImporter;
use Backstage\Redirects\Filament\Resources\RedirectResource;
use Backstage\Redirects\Laravel\Models\Redirect;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\ActionSize;

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
                    ])
                    ->action(function ($data) {
                        $sourceLines = preg_split('/\r\n|\r|\n/', $data['sources']);
                        $destinationLines = preg_split('/\r\n|\r|\n/', $data['destinations']);

                        $redirects = [];

                        foreach ($sourceLines as $index => $source) {
                            $destination = $destinationLines[$index] ?? null;

                            if ($destination !== null) {
                                $redirects[] = [
                                    'code' => $data['code'],
                                    'source' => trim($source),
                                    'destination' => trim($destination),
                                ];
                            }
                        }

                        foreach ($redirects as $redirect) {
                            Redirect::updateOrCreate([
                                'source' => $redirect['source'],
                                'site_id' => Filament::getTenant()->ulid,
                            ], [
                                'destination' => $redirect['destination'],
                                'code' => $redirect['code'],
                            ]);
                        }
                    }),
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
