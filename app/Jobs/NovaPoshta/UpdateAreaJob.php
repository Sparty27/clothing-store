<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshta\AreaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateAreaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(AreaService $service): void
    {
        try {
            $service->updateAreas();
        } catch (\Exception $e) {
            Log::error("Помилка у UpdateAreaJob, job id {$this->job->uuid()}, (UpdateAreaJob->handle): ".$e->getMessage());
        }
    }
}
