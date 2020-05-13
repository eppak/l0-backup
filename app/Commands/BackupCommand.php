<?php

namespace App\Commands;

use Eppak\Backup;
use Eppak\Configuration;
use Eppak\Contexts\Command as Context;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;




class BackupCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'backup';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        parent::__construct();

        $this->configuration = $configuration;
    }

    /**
     * Execute the console command.
     *
     * @param Backup $backup
     * @return mixed
     */
    public function handle(Backup $backup)
    {
        $backup->run(new Context($this));

        return 0;
    }

    /**
     * Define the command's schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        $cron = $this->configuration->get('schedule');

        if ($cron) {
            $schedule->command(static::class)->cron($cron);
        }
    }
}
