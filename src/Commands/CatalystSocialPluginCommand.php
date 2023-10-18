<?php

namespace OmniaDigital\CatalystSocialPlugin\Commands;

use Illuminate\Console\Command;

class CatalystSocialPluginCommand extends Command
{
    public $signature = 'catalyst-social-plugin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
