<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshta\CityService;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateCityJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $page;
    private int $limit;

    /**
     * Create a new job instance.
     */
    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(CityService $service): void
    {
        Log::debug('JobId: '.$this->job->getJobId().' Memory usage before processing: ' . memory_get_usage());

        if ($this->batch()->cancelled()) {
            return;
        }

        try {
            $service->updateCities($this->page, $this->limit);
        } catch (Exception $e) {
            Log::error("Помилка у UpdateCityJob, job id {$this->job->uuid()}, (UpdateCityJob->handle): ".$e->getMessage());
        }

        Log::debug('JobId: '.$this->job->getJobId().' Memory usage after processing: ' . memory_get_usage());
    }
}
