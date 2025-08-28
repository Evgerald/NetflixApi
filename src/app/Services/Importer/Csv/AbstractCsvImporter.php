<?php

namespace App\Services\Importer\Csv;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Log;
use Throwable;

/**
 * AbstractCsv Importer
 *
 * @version 1.0
 */
abstract class AbstractCsvImporter
{
    /**
     * @param array $batch
     * @param Collection $tableParams
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function insertBatch(array $batch, Collection $tableParams): void
    {
        try {
            DB::table($tableParams->get('table'))->upsert($batch, $tableParams->get('unique'));
        } catch (Throwable $e) {
            Log::error('Batch import failed', [
                'error' => $e->getMessage(),
                'rows'  => $batch,
            ]);

            // Throw error to stop job and next jobs in chain due to avoid error with related data insert
            // Example: insert records into review with foreign key on user_id
            throw $e;
        }
    }
}
