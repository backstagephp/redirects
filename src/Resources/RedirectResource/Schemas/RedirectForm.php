<?php

namespace Backstage\Redirects\Filament\Resources\RedirectResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Redirect')
                            ->schema([
                                Select::make('code')
                                    ->label(__('Type'))
                                    ->columnSpanFull()
                                    ->options(collect(config('redirects.status_codes', []))->map(fn (string $type, int $code) => $code . ' ' . $type))
                                    ->searchable()
                                    ->required()
                                    ->default(config('redirects.default_status_code'))
                                    ->prefixIcon('heroicon-o-map-pin')
                                    ->inlinePrefix()
                                    ->placeholder('HTTP status message'),
                                TextInput::make('source')
                                    ->label(__('Source'))
                                    ->columnSpanFull()
                                    ->required()
                                    ->prefixIcon('heroicon-o-arrow-uturn-right')
                                    ->inlinePrefix()
                                    ->placeholder(__('Type path, URL or pattern...'))
                                    ->helperText(__('The path to match, you can use regular expressions.')),
                                TextInput::make('destination')
                                    ->label(__('Destination'))
                                    ->columnSpanFull()
                                    ->required()
                                    ->different('source')
                                    ->prefixIcon('heroicon-o-arrow-uturn-left')
                                    ->inlinePrefix()
                                    ->placeholder('Type path or URL...')
                                    ->validationMessages([
                                        'different' => __('Source and destination can never be the same!'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
