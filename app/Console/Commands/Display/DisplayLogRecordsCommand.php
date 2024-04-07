<?php

namespace App\Console\Commands\Display;

use App\Models\Log;

class DisplayLogRecordsCommand extends DisplayLogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:display-log-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display records from the database within a specified time range using Log';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->validDate();

        $this->info('Fetching records from the database...');

        Log::select([
            'remote_addr',
            'remote_user',
            'time_local',
            'request',
            'status',
            'body_bytes_sent',
            'http_referer',
            'http_user_agent',
        ])
            ->preWhere('time_local', '>=', $this->startDate->startOfDay()->toDateTimeString())
            ->preWhere('time_local', '<=', $this->finishDate->endOfDay()->toDateTimeString())
            ->chunk(
                10,
                function (array $records) {
                    $this->table(
                        [
                            'Remote Address',
                            'Remote User',
                            'Time Local',
                            'Request',
                            'Status',
                            'Body Bytes Sent',
                            'HTTP Referer',
                            'HTTP User Agent',
                        ],
                        $records
                    );
                }
            );

        $this->info('Records displayed.');
    }
}
