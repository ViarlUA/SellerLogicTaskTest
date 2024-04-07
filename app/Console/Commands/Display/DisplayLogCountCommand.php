<?php

namespace App\Console\Commands\Display;

use App\Models\Log;
use PhpClickHouseLaravel\RawColumn;

class DisplayLogCountCommand extends DisplayLogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'display-log:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the count of records from the database within a specified time range using Log';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->validDate();

        $this->info('Fetching records from the database...');

        $count = Log::select([
            new RawColumn('count(*) as count'),
        ])
            ->where('time_local', '>=', $this->startDate->startOfDay()->toDateTimeString())
            ->where('time_local', '<=', $this->finishDate->endOfDay()->toDateTimeString())
            ->getRows()[0]['count'] ?? 0;

        $this->info('Records count: ' . $count);
    }
}
