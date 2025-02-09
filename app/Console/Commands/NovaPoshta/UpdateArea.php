<?php

namespace App\Console\Commands\NovaPoshta;

use App\Jobs\NovaPoshta\UpdateAreaJob;
use Illuminate\Console\Command;

class UpdateArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'np:update-area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get areas from NovaPoshta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UpdateAreaJob::dispatch();
    }
}
