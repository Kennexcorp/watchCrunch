<?php

namespace App\Jobs;

use App\Services\TopUserDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TopUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $noOfDays;
    /**
     * @var int
     */
    private $maxPostCount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $noOfDays, int $maxPostCount)
    {
        $this->noOfDays = $noOfDays;
        $this->maxPostCount = $maxPostCount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TopUserDataService $userService)
    {
        $userService->topUserData($this->noOfDays, $this->maxPostCount);
    }
}
