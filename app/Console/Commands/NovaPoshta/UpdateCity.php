<?php

namespace App\Console\Commands\NovaPoshta;

use App\Jobs\NovaPoshta\UpdateCityJob;
use App\Models\City;
use App\Services\NovaPoshta\NovaPoshtaService;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class UpdateCity extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'np:update-city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get cities from NovaPoshta';

    /**
     * Execute the console command.
     */
    public function handle(NovaPoshtaService $novaPoshtaService)
    {
        $limit = 50;

        $totalCount = $novaPoshtaService::getTotalCount($novaPoshtaService::CITIES);

        if (!$totalCount) {
            return;
        }

        $jobsNeeded = (int) ceil($totalCount / $limit);
        $startTime = now();
        $batch = [];

        for ($page = 1; $page <= $jobsNeeded; $page++) {
            $batch[] = new UpdateCityJob($page, $limit);
        }

        $bar = $this->output->createProgressBar($jobsNeeded);
        $bar->start();

        $batch = Bus::batch($batch)
            ->before(function (Batch $batch) {
            })
            ->then(function (Batch $batch) {
            })
            ->finally(function (Batch $batch) use($startTime) {
                City::where('updated_at', '<', $startTime)->delete();
            })
            ->dispatch();
        
        while (true) {
            $updateBatch = $batch->fresh();

            if (!$updateBatch) {
                $this->error('Batch is not found');
                break;
            }

            $processedJobs = $updateBatch->processedJobs();

            if ($processedJobs > 0) {
                $bar->setProgress($processedJobs);
            }
        
            if ($processedJobs >= $jobsNeeded) {
                $this->newLine();
                $this->info('All jobs processed successfully');
                $bar->finish();
                break;
            } else if ($updateBatch->finished()) {
                $this->newLine();
                $this->info('Batch is finished');
                break;
            }
            
            unset($updateBatch, $processedJobs);
            sleep(1);
        }
    }
}
