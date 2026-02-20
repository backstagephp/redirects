<?php

use Backstage\Redirects\Filament\Resources\RedirectResource;

return [
    'navigation' => [
        'parent' => null,
        'group' => null,
        'sort' => 10,
    ],

    'resources' => [
        RedirectResource::class,
    ],

    'scopesToTenant' => true,
];
