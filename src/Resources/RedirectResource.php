<?php

namespace Backstage\Redirects\Filament\Resources;

use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\CreateRedirect;
use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\EditRedirect;
use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\ListRedirects;
use Backstage\Redirects\Laravel\Models\Redirect;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $tenantOwnershipRelationshipName = 'site';

    public static function getModel(): string
    {
        return config('redirects.model', Redirect::class);
    }

    public static function isScopedToTenant(): bool
    {
        return config('backstage.redirects.scopesToTenant', false);
    }

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrows-right-left';

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

    public static function form(Schema $schema): Schema
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
                                    ->placeholder('HTTP status message'),
                                TextInput::make('source')
                                    ->label(__('Source'))
                                    ->columnSpanFull()
                                    ->required()
                                    ->prefixIcon('heroicon-o-arrow-uturn-right')
                                    ->placeholder(__('Type path, URL or pattern...'))
                                    ->helperText(__('The path to match, you can use regular expressions.')),
                                TextInput::make('destination')
                                    ->label(__('Destination'))
                                    ->columnSpanFull()
                                    ->required()
                                    ->different('source')
                                    ->prefixIcon('heroicon-o-arrow-uturn-left')
                                    ->placeholder('Type path or URL...')
                                    ->validationMessages([
                                        'different' => __('Source and destination can never be the same!'),
                                    ]),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
