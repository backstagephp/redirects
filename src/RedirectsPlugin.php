<?php

namespace Vormkracht10\FilamentRedirects;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Vormkracht10\FilamentRedirects\Resources\RedirectResource;

class RedirectsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'redirects';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            RedirectResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
