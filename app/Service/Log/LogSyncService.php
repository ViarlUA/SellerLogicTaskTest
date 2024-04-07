<?php

namespace App\Service\Log;

use App\Models\Log;
use App\Service\ReaderLog\ReadLogFileService;
use Carbon\CarbonImmutable;

class LogSyncService
{
    public const string DEFAULT_PATH_TO_LOG = '/var/log/nginx/access.log';

    /**
     * @throws \Exception
     */
    public function syncLogs(string $path, int $chunk = 10_000): void
    {
        $readLog = new ReadLogFileService($path, $chunk);

        $lastLog = $this->getLastLog();
        $skipLog = fn (array $log) => $this->shouldSkipLog($log, $lastLog);

        foreach ($readLog->read($skipLog) as $log) {
            Log::insertAssoc($log);
        }
    }

    private function getLastLog(): ?CarbonImmutable
    {
        $logTime = Log::select('time_local')
                       ->orderByDesc('time_local')
                       ->limit(1)
                       ->getRows()[0]['time_local'] ?? null;

        return $logTime ? CarbonImmutable::make($logTime) : null;
    }

    /**
     * @param array<string, mixed>         $log
     * @param null|\Carbon\CarbonImmutable $lastLog
     *
     * @return bool
     */
    private function shouldSkipLog(array $log, ?CarbonImmutable $lastLog): bool
    {
        /* @phpstan-ignore-next-line  */
        return $lastLog && $log['time_local']->lessThanOrEqualTo($lastLog);
    }
}
