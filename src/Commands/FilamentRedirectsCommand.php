<?php

namespace Vormkracht10\FilamentRedirects\Commands;

use Illuminate\Console\Command;

class FilamentRedirectsCommand extends Command
{
    public $signature = 'filament-redirects';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
