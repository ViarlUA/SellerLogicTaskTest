<?php

namespace App\Console\Commands\Log;

use App\Service\Log\LogSyncService;

class ReadLogNginxCommand extends LogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:read-log-nginx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reading Nginx logs and save new data to ClickHouse';

    public function __construct(
        private readonly LogSyncService $logSyncService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $path = $this->getPath();

        $chunk = $this->getChunk();

        $this->info('Start sync log from ' . $path);

        $this->logSyncService->syncLogs($path, $chunk);

        $this->info('End sync log from ' . $path);
    }
}
