<?php

namespace App\Console\Commands\Display;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

abstract class DisplayLogCommand extends Command
{
    protected ?CarbonImmutable $startDate;
    protected ?CarbonImmutable $finishDate;

    public function validDate(): void
    {
        $this->startDate  = CarbonImmutable::make($this->argument('startDate'));
        $this->finishDate = CarbonImmutable::make($this->argument('finishDate'));

        if (! $this->startDate && ! $this->finishDate) {
            throw new InvalidArgumentException('Invalid date format.');
        }

        if ($this->finishDate->lessThan($this->startDate)) {
            throw new InvalidArgumentException('Finish date cannot be earlier than start date.');
        }
    }

    protected function configure(): void
    {
        $this->addArgument('startDate', InputArgument::REQUIRED, 'Start date');
        $this->addArgument('finishDate', InputArgument::REQUIRED, 'Finish date');
    }
}
