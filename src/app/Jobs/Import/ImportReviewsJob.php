<?php

namespace App\Jobs\Import;

use App\Factories\Import\ReviewsImporterFactory;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * ImportReviews Job
 *
 * @version 1.0
 */
class ImportReviewsJob implements ShouldQueue
{
    use Queueable, Batchable;

    private string $file;

    /**
     * Create a new job instance.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(ReviewsImporterFactory $factory): void
    {
        $start = microtime(true);
        $startMemory = memory_get_usage();

        $factory->make($this->file)->import($this->file);

        $executionTime = microtime(true) - $start;
        $memoryUsed = memory_get_usage() - $startMemory;

        Log::info('Import reviews finished at: ' . now()->format('Y-m-d H:i:s'), [
            'time'   => round($executionTime, 4) . ' sec',
            'memory' => round($memoryUsed / 1024 / 1024, 4) . ' MB',
        ]);
    }

    /**
     * @param Throwable $e
     *
     * @return void
     */
    public function failed(Throwable $e): void
    {
        Log::error('ImportReviewsJob failed', [
            'file'  => $this->file,
            'error' => $e->getMessage(),
        ]);
    }

    /**
     * @return array
     */
    public function middleware(): array
    {
        return [
            new WithoutOverlapping('import_reviews')->expireAfter(3600) // to avoid permanent lock if job failed
        ];
    }
}
