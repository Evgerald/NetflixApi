<?php

namespace App\Services\Importer;

use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Import Dispatcher
 *
 * @version 2.0
 *
 * @since version 2.0 added single level jobs processing capability and adding dependent jobs to chain
 */
class ImportDispatcher
{
    /**
     * @param array $files
     * @return void
     *
     * @throws Throwable
     */
    public function dispatch(array $files): void
    {
        $jobsMapping = config('import.jobs');
        $jobsPriority = config('import.jobs_priorities');
        $jobsWithoutPriorities = $this->getJobsWithoutPriorities($jobsMapping, $jobsPriority, $files);

        try {
            Bus::batch($jobsWithoutPriorities)->dispatch();
        } catch (Exception $e) {
            Log::error('Jobs without priorities failed', [
                'jobs' => json_encode($jobsWithoutPriorities),
                'error' => $e->getMessage(),
            ]);
        }

        $this->processJobsWithPriorities($jobsMapping, $jobsPriority, $files);
    }

    /**
     * @param array $jobsMapping
     * @param array $jobsPriority
     * @param array $files
     *
     * @return array
     */
    private function getJobsWithoutPriorities(array &$jobsMapping, array $jobsPriority, array $files): array
    {
        $jobsWithoutPriorities = [];

        foreach ($files as $key => $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            if (!array_key_exists($name, $jobsPriority) && !in_array($name, array_merge(...array_values($jobsPriority)))) {
                if (isset($jobsMapping[$name])) {
                    $jobClass = $jobsMapping[$name];
                    $jobsWithoutPriorities[] = new $jobClass($file);
                    unset($jobsMapping[$name]);
                    unset($files[$key]);
                }
            }
        }

        return $jobsWithoutPriorities;
    }

    /**
     * @param array $jobsMapping
     * @param array $jobsPriority
     * @param array $files
     *
     * @return void
     */
    private function processJobsWithPriorities(array $jobsMapping, array $jobsPriority, array $files)
    {
        $jobsWithoutDependencies = array_diff_key($jobsMapping, $jobsPriority);
        $jobs = [];
        // Collect jobs for processing
        foreach ($files as $key => $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);

            if (isset($jobsWithoutDependencies[$name])) {
                $jobClass = $jobsWithoutDependencies[$name];
                $jobs[] = new $jobClass($file);
                unset($jobsMapping[$name]);
                unset($files[$key]);
            }
        }

        // Clear dependencies in jobs
        $jobsPriority = array_filter(
            array_map(
                fn($deps) => array_values(array_intersect($deps, array_keys($jobsPriority))),
                $jobsPriority
            ),
            fn($value) => !empty($value)
        );

        try {
            Bus::batch($jobs)
                ->then(function () use ($jobsMapping, $jobsPriority, $files) {
                    // Call this function again if chain was successful
                    $this->processJobsWithPriorities($jobsMapping, $jobsPriority, $files);
                })
                ->dispatch();
        } catch (Throwable $e) {
            Log::error('Jobs with priorities failed', [
                'jobs' => json_encode($jobs),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
