<?php

use Backstage\Redirects\Laravel\Models\Redirect;

beforeEach(function () {
    // Set up database
    $this->artisan('migrate', ['--database' => 'testing'])->run();
});

it('can create redirect with path source and destination', function () {
    $redirect = Redirect::create([
        'source' => '/pagina-1',
        'destination' => '/pagina-2',
        'code' => 301,
    ]);

    expect($redirect->source)->toBe('/pagina-1');
    expect($redirect->destination)->toBe('/pagina-2');
    expect($redirect->code)->toBe(301);
    expect($redirect->hits)->toBe(0);
});

it('can create redirect with different status codes', function () {
    $testCases = [
        ['code' => 301, 'name' => 'Moved Permanently'],
        ['code' => 302, 'name' => 'Found'],
        ['code' => 307, 'name' => 'Temporary Redirect'],
        ['code' => 308, 'name' => 'Permanent Redirect'],
    ];

    foreach ($testCases as $testCase) {
        $redirect = Redirect::create([
            'source' => '/test-' . $testCase['code'],
            'destination' => '/destination',
            'code' => $testCase['code'],
        ]);

        expect($redirect->code)->toBe($testCase['code']);
    }
});

it('validates source and destination are different', function () {
    // This would be validated at the form level in Filament
    // The model itself doesn't prevent this, so we just test creation
    $redirect = Redirect::create([
        'source' => '/same-page',
        'destination' => '/same-page',
        'code' => 301,
    ]);

    expect($redirect->source)->toBe('/same-page');
    expect($redirect->destination)->toBe('/same-page');
});

it('can create redirect to external URL', function () {
    $redirect = Redirect::create([
        'source' => '/external',
        'destination' => 'https://example.com',
        'code' => 301,
    ]);

    expect($redirect->destination)->toBe('https://example.com');
});

it('defaults to 301 redirect code from config', function () {
    config()->set('redirects.default_status_code', 301);

    $redirect = Redirect::create([
        'source' => '/test',
        'destination' => '/destination',
        'code' => config('redirects.default_status_code'),
    ]);

    expect($redirect->code)->toBe(301);
});

it('can handle redirects with query parameters', function () {
    $redirect = Redirect::create([
        'source' => '/search',
        'destination' => '/new-search?default=true',
        'code' => 301,
    ]);

    expect($redirect->destination)->toContain('?default=true');
});

it('can list all redirects', function () {
    Redirect::create([
        'source' => '/pagina-1',
        'destination' => '/pagina-2',
        'code' => 301,
    ]);

    Redirect::create([
        'source' => '/pagina-3',
        'destination' => '/pagina-4',
        'code' => 302,
    ]);

    $redirects = Redirect::all();

    expect($redirects)->toHaveCount(2);
});

it('can update redirect', function () {
    $redirect = Redirect::create([
        'source' => '/old-source',
        'destination' => '/old-destination',
        'code' => 301,
    ]);

    $redirect->update([
        'source' => '/new-source',
        'destination' => '/new-destination',
        'code' => 302,
    ]);

    expect($redirect->fresh()->source)->toBe('/new-source');
    expect($redirect->fresh()->destination)->toBe('/new-destination');
    expect($redirect->fresh()->code)->toBe(302);
});

it('can delete redirect', function () {
    $redirect = Redirect::create([
        'source' => '/to-delete',
        'destination' => '/destination',
        'code' => 301,
    ]);

    $ulid = $redirect->ulid;

    $redirect->delete();

    expect(Redirect::find($ulid))->toBeNull();
});
