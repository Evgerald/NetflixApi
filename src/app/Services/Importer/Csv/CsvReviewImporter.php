<?php

namespace App\Services\Importer\Csv;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Transformers\Import\Csv\ReviewTransformer;
use App\Utilities\CSV\CsvReader;
use Throwable;

/**
 * CsvReview Importer
 *
 * @version 1.0
 */
class CsvReviewImporter extends AbstractCsvImporter implements ImporterInterface
{
    /**
     * @param string $file
     *
     * @return void
     *
     * @throws Throwable
     */
    public function import(string $file): void
    {
        $batch = [];
        $tableData = collect(['table' => 'reviews', 'unique' => 'review_id']);

        foreach (CsvReader::read($file) as $row) {
            $batch[] = ReviewTransformer::transform($row);

            if (count($batch) === 1) {
                $this->insertBatch($batch, $tableData);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->insertBatch($batch, $tableData);
        }
    }
}
