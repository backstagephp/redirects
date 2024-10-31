<?php

namespace Vormkracht10\FilamentRedirects\Resources;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Schema;
use Locale;
use Vormkracht10\Backstage\Models\Language;
use Vormkracht10\Backstage\Models\Site;
use Vormkracht10\FilamentRedirects\Resources\RedirectResource\Pages;
use Vormkracht10\Redirects\Models\Redirect;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

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
                Section::make('From')
                    ->columns([
                        'sm' => 1,
                        'md' => 12,
                    ])
                    ->schema([
                        Select::make('site_ulid')
                            ->label(__('Site'))
                            ->columnSpan(4)
                            ->placeholder(__('Select Site'))
                            ->prefixIcon('heroicon-o-link')
                            ->options(Site::orderBy('default', 'desc')->orderBy('name', 'asc')->pluck('name', 'ulid'))
                            ->default(Site::where('default', true)->first()?->ulid)
                            ->visible(fn() => Schema::hasColumn('redirects', 'content_ulid') && Site::count() > 0)
                            ->hidden(fn() => Schema::hasColumn('redirects', 'content_ulid') && Site::count() === 1),
                        Select::make('country_code')
                            ->label(__('Country'))
                            ->columnSpan(4)
                            ->placeholder(__('Select Country'))
                            ->prefixIcon('heroicon-o-globe-europe-africa')
                            ->options(Language::whereNotNull('country_code')->distinct('country_code')->get()->mapWithKeys(fn($language) => [
                                $language->code => '<img src="data:image/svg+xml;base64,' . base64_encode(file_get_contents(base_path('vendor/vormkracht10/backstage/resources/img/flags/' . $language->code . '.svg'))) . '" class="w-5 inline-block relative" style="top: -1px; margin-right: 3px;"> ' . Locale::getDisplayLanguage($language->code, app()->getLocale())
                            ])->sort())
                            ->allowHtml()
                            ->default(Language::whereNotNull('country_code')->distinct('country_code')->count() === 1 ? Language::whereNotNull('country_code')->first()->country_code : null)
                            ->visible(fn() => Schema::hasColumn('redirects', 'content_ulid') && Language::whereNotNull('country_code')->distinct('country_code')->count() > 0)
                            ->hidden(fn() => Schema::hasColumn('redirects', 'content_ulid') && Language::whereNotNull('country_code')->distinct('country_code')->count() === 1),
                        Select::make('language_code')
                            ->label(__('Language'))
                            ->columnSpan(4)
                            ->placeholder(__('Select Language'))
                            ->prefixIcon('heroicon-o-language')
                            ->options(
                                Language::get()->mapWithKeys(fn($language) => [
                                    $language->code => '<img src="data:image/svg+xml;base64,' . base64_encode(file_get_contents(base_path('vendor/vormkracht10/backstage/resources/img/flags/' . $language->code . '.svg'))) . '" class="w-5 inline-block relative" style="top: -1px; margin-right: 3px;"> ' . Locale::getDisplayLanguage($language->code, app()->getLocale())
                                ])->sort()
                            )
                            ->allowHtml()
                            ->default(Language::count() === 1 ? Language::first()->code : Language::where('default', true)->first()->code)
                            ->visible(fn() => Schema::hasColumn('redirects', 'content_ulid') && Language::count() > 0)
                            ->hidden(fn() => Schema::hasColumn('redirects', 'content_ulid') && Language::count() === 1),
                        TextInput::make('source')
                            ->label(__('Source'))
                            ->columnSpan(12)
                            ->required()
                            ->prefixIcon('heroicon-o-arrow-uturn-right')
                            ->placeholder(__('Type path, URL or pattern...'))
                            ->helperText(__('The path to match, you can use regular expressions.')),
                    ]),
                Section::make('To')
                    ->columns([
                        'sm' => 1,
                        'md' => 12,
                    ])
                    ->schema([
                        Select::make('code')
                            ->label(__('Type'))
                            ->columnSpan(4)
                            ->native(false)
                            ->options(collect(config('redirects.status_codes'))->map(fn(string $type, int $code) => $type . ' (' . $code . ')'))
                            ->searchable()
                            ->required()
                            ->default(config('redirects.default_status_code'))
                            ->prefixIcon('heroicon-o-hashtag')
                            ->placeholder('HTTP status message'),
                        Select::make('content')
                            ->label(__('Content'))
                            ->columnSpan(8)
                            ->placeholder('Content')
                            ->prefixIcon('heroicon-o-link')
                            ->helperText(__('Select a content page to redirect to the current URL.'))
                            ->visible(fn() => Schema::hasColumn('redirects', 'content_ulid')),
                        TextInput::make('destination')
                            ->label(__('Destination'))
                            ->columnSpan(12)
                            ->required()
                            ->prefixIcon('heroicon-o-arrow-uturn-left')
                            ->placeholder('Type path or URL...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('destination')
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
