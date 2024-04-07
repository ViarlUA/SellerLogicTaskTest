<?php

namespace App\Console\Commands\Display;

use App\Models\Log;
use Symfony\Component\Console\Helper\Table;

class DisplayLogRecordsCommand extends DisplayLogCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'display-log:records {--chunk=100} {--vertical}';

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

        $chunk    = $this->option('chunk');
        $vertical = $this->option('vertical') ?? false;

        $this->info('Fetching records from the database...');
        $page = 1;

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
                $chunk,
                function (array $records) use (&$page, $vertical) {
                    if (empty($records)) {
                        return;
                    }

                    $table = new Table($this->output);

                    $table->setHeaders([
                        'Remote Address',
                        'Remote User',
                        'Time Local',
                        'Request',
                        'Status',
                        'Body Bytes Sent',
                        'HTTP Referer',
                        'HTTP User Agent',
                    ])
                        ->setRows($records)
                        ->setStyle('default')
                        ->setVertical($vertical)
                        ->setFooterTitle("Page $page");

                    $page++;

                    $table->render();
                }
            );

        $this->info('Records displayed.');
    }
}
