<?php

namespace App\Commands;

use Eppak\Local;
use Eppak\PkZip;
use Eppak\S3;
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $local = new Local('/home/alkeidon/test/');


	new S3();

        // $zip = new PkZip('/home/alkeidon/test.zip');
        // $zip->add('test.txt', time());

    }

    /**
     * Define the command's schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
