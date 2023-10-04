<?php

namespace OmniaDigital\CatalystCore\Commands;

use Illuminate\Console\Command;

class CatalystCoreCommand extends Command
{
    public $signature = 'catalyst-core-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
