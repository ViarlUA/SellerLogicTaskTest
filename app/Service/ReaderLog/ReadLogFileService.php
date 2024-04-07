<?php

namespace App\Service\ReaderLog;

use Generator;
use RuntimeException;
use SplFileObject;

class ReadLogFileService extends ReadLogService
{
    /**
     * @var null|\SplFileObject
     */
    private ?SplFileObject $file;

    public function __construct(
        string $path,
        private readonly int $chunk = 1000,
    ) {
        $this->file = new SplFileObject($path, 'rb');

        if (! $this->file->isReadable()) {
            throw new RuntimeException('Failed to open file');
        }
    }

    public function __destruct()
    {
        if ($this->file) {
            $this->file = null;
        }
    }

    /**
     * @inheritDoc
     */
    public function read(?callable $skipLog = null): Generator
    {
        if(! $this->file) {
            throw new RuntimeException('Failed to open file');
        }

        while (! $this->file->eof()) {
            $lines = [];

            /* @phpstan-ignore-next-line  */
            for ($i = 0; $i < $this->chunk && (! $this->file->eof()); $i++) {
                $data = $this->file->fgets();

                if (! $data) {
                    continue;
                }

                $log = $this->parseLog($data);

                if (! $log) {
                    continue;
                }

                if ($skipLog && $skipLog($log)) {
                    continue;
                }

                $lines[] = $log;
            }

            if (! empty($lines)) {
                yield $lines;
            }
        }
    }
}
