<?php

namespace App\Service\ReaderLog;

use Carbon\CarbonImmutable;
use Generator;

abstract class ReadLogService
{
    /**
     * @param null|callable(array{remote_addr: string, remote_user:string, time_local: CarbonImmutable, request: string, status: int, body_bytes_sent:int, http_referer: string, http_user_agent: string}):bool $skipLog
     *
     * @throws \Exception
     * @return \Generator<array-key, non-empty-array<array-key, array{remote_addr: string, remote_user:string, time_local: CarbonImmutable, request: string, status: int, body_bytes_sent:int, http_referer: string, http_user_agent: string}>>
     */
    abstract public function read(?callable $skipLog = null): Generator;

    /**
     * @param string $log
     *
     * @throws \Exception
     * @return array{remote_addr: string, remote_user:string, time_local: CarbonImmutable, request: string, status: int, body_bytes_sent:int, http_referer: string, http_user_agent: string}|false
     */
    protected function parseLog(string $log): array|false
    {
        $matches = [];

        $pattern = '/^(\S+) (\S+) (\S+) \[([^\]]+)\] "([^"]+)" (\d+) (\d+) "([^"]+)" "([^"]+)"$/';

        if (! preg_match($pattern, $log, $matches)) {
            return false;
        }

        return [
            'remote_addr'     => $matches[1],
            'remote_user'     => $matches[2],
            'time_local'      => new CarbonImmutable($matches[4]),
            'request'         => $matches[5],
            'status'          => (int)$matches[6],
            'body_bytes_sent' => (int)$matches[7],
            'http_referer'    => $matches[8],
            'http_user_agent' => $matches[9],
        ];
    }
}
