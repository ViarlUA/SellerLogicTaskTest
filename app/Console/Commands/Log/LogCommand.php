<?php

namespace App\Console\Commands\Log;

use App\Service\Log\LogSyncService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class LogCommand extends Command
{
    protected function configure(): void
    {
        $this->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path to the log file', LogSyncService::DEFAULT_PATH_TO_LOG);
        $this->addOption('chunk', null, InputOption::VALUE_OPTIONAL, 'Chunk size', 10_000);
    }

    protected function getPath(): string
    {
        return (string)$this->option('path');
    }

    protected function getChunk(): int
    {
        return (int)$this->option('chunk');
    }
}
