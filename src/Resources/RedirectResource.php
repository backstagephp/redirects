<?php

namespace Backstage\Redirects\Filament\Resources;

use Backstage\Redirects\Filament\Resources\RedirectResource\Pages;
use Backstage\Redirects\Laravel\Models\Redirect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    public static function getModel(): string
    {
        return config('redirects.model', Redirect::class);
    }

    public static function isScopedToTenant(): bool
    {
        return config('backstage.redirects.scopesToTenant', false);
    }

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function getNavigationParentItem(): ?string
    {
        return config('filament-redirects.navigation.parent');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('backstage.redirects.navigation.group');
    }

    public static function getNavigationSort(): ?int
    {
        return config('backstage.redirects.navigation.sort');
    }

    public static function getModelLabel(): string
    {
        return __('Redirect');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Redirects');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Redirect')
                            ->schema([
                                Select::make('code')
                                    ->label(__('Type'))
                                    ->columnSpanFull()
                                    ->options(collect(config('redirects.status_codes'))->map(fn (string $type, int $code) => $code . ' ' . $type))
                                    ->searchable()
                                    ->required()
                                    ->default(config('redirects.default_status_code'))
                                    ->prefixIcon('heroicon-o-map-pin')
                                    ->placeholder('HTTP status message'),
                                TextInput::make('source')
                                    ->label(__('Source'))
                                    ->url()
                                    ->columnSpanFull()
                                    ->required()
                                    ->prefixIcon('heroicon-o-arrow-uturn-right')
                                    ->placeholder(__('Type path, URL or pattern...'))
                                    ->helperText(__('The path to match, you can use regular expressions.')),
                                TextInput::make('destination')
                                    ->label(__('Destination'))
                                    ->url()
                                    ->columnSpanFull()
                                    ->required()
                                    ->prefixIcon('heroicon-o-arrow-uturn-left')
                                    ->placeholder('Type path or URL...'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->badge()
                    ->width(0)
                    ->searchable()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        '301' => 'info',
                        '302' => 'gray',
                        '307' => 'warning',
                        '308' => 'info',
                    }),
                TextColumn::make('source')
                    ->width('50%')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hits')
                    ->searchable()
                    ->sortable()
                    ->alignRight()
                    ->formatStateUsing(fn (string $state): string => $state . ' ×')
                    ->width(50),
                TextColumn::make('destination')
                    ->width('50%')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
