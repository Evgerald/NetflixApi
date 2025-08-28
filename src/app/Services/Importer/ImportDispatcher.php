<?php

namespace App\Services\Importer;

use Illuminate\Support\Facades\Bus;

/**
 * Import Dispatcher
 *
 * @TODO implement logic when jobs the same level could execute at the same time and if successfully completed then jobs with lower priority should be executed
 *
 * @version 1.0
 */
class ImportDispatcher
{
    /**
     * @param array $files
     *
     * @return void
     */
    public function dispatch(array $files): void
    {
        $jobsMapping = config('import.jobs');
        $jobs = [];

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);

            if (isset($jobsMapping[$name])) {
                $jobClass = $jobsMapping[$name];
                $jobs[] = new $jobClass($file);
            }
        }

        if (empty($jobs)) {
            return;
        }

        if (count($jobs) > 1) {
            Bus::chain($jobs)->dispatch();
        } else {
            dispatch($jobs[0]);
        }
    }
}
