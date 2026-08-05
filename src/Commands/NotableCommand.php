<?php

namespace MohamedSaid\Notable\Commands;

use Illuminate\Console\Command;

class NotableCommand extends Command
{
    public $signature = 'notable';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment(__('All done'));

        return self::SUCCESS;
    }
}
