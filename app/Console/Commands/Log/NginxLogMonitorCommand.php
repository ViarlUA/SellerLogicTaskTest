<?php

namespace App\Console\Commands\Log;

use App\Models\Log;
use App\Service\Log\LogSyncService;
use App\Service\ReaderLog\ReadLogTailService;
use Laravel\Telescope\Telescope;

class NginxLogMonitorCommand extends LogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monitor-log-nginx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor Nginx access log and save new data to ClickHouse';

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
        pcntl_signal(SIGINT, function () {
            $this->alert('End monitor logs. Exiting...');
            exit;
        });

        $path  = $this->getPath();
        $chunk = $this->getChunk();

        $this->syncLogs($path, $chunk);

        $this->monitorLogs($path);

        pcntl_signal_dispatch();
    }

    /**
     * @param string $path
     * @param int    $chunk
     *
     * @throws \Exception
     * @return void
     */
    private function syncLogs(string $path, int $chunk): void
    {
        $this->info('Start sync log from ' . $path);

        $this->logSyncService->syncLogs($path, $chunk);

        $this->info('End sync log');
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     * @return void
     */
    private function monitorLogs(string $path): void
    {
        Telescope::stopRecording();
        $readLog = new ReadLogTailService($path);
        $this->info('Start monitor log from ' . $path);

        foreach ($readLog->read() as $log) {
            Log::insertAssoc($log);
        }

        $this->info('End monitor log');
    }
}
