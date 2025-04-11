<?php

namespace Backstage\Redirects\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;

class RedirectsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'redirects';
    }

    public function register(Panel $panel): void
    {
        $panel->resources(config('backstage.redirects.resources', []));
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
