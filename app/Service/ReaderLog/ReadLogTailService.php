<?php

namespace App\Service\ReaderLog;

use Generator;
use Symfony\Component\Process\Process;

class ReadLogTailService extends ReadLogService
{
    private Process $process;

    public function __construct(
        string $path,
    ) {
        $this->process = new Process(['tail', '-f', $path]);
    }

    public function __destruct()
    {
        $this->process->stop();
    }

    /**
     * @inheritDoc
     */
    public function read(?callable $skipLog = null): Generator
    {
        $this->process->start();

        while ($this->process->isRunning()) {
            while ($data = $this->process->getIncrementalOutput()) {
                $log = $this->parseLog($data);

                if (! $log) {
                    continue;
                }

                yield [$log];
            }
        }
    }
}
