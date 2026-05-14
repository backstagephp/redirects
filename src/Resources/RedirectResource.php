<?php

namespace Backstage\Redirects\Filament\Resources;

use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\CreateRedirect;
use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\EditRedirect;
use Backstage\Redirects\Filament\Resources\RedirectResource\Pages\ListRedirects;
use Backstage\Redirects\Filament\Resources\RedirectResource\Schemas\RedirectForm;
use Backstage\Redirects\Filament\Resources\RedirectResource\Tables\RedirectTable;
use Backstage\Redirects\Laravel\Models\Redirect;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
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
        return RedirectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectTable::configure($table);
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
