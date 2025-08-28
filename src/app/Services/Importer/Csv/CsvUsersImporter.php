<?php

namespace App\Services\Importer\Csv;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Transformers\Import\Csv\UserTransformer;
use App\Utilities\CSV\CsvReader;
use Throwable;

/**
 * CsvUsers Importer
 *
 * Create or update records by user_id in Users table
 *
 * @version 1.0
 */
class CsvUsersImporter extends AbstractCsvImporter implements ImporterInterface
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
        $tableData = collect(['table' => 'users', 'unique' => 'user_id']);

        foreach (CsvReader::read($file) as $row) {
            $batch[] = UserTransformer::transform($row);

            if (count($batch) === self::BATCH_SIZE) {
                $this->insertBatch($batch, $tableData);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->insertBatch($batch, $tableData);
        }
    }
}
