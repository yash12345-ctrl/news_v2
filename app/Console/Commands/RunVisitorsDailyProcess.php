<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunVisitorsDailyProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-visitors-daily-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run IP geo lookup first, then generate daily visitor summary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('app:ip-geo-lookup');
        Artisan::call('app:generate-visitors-daily-summary');
    }
}
