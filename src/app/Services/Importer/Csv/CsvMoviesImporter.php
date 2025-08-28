<?php

namespace App\Services\Importer\Csv;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Transformers\Import\Csv\MovieTransformer;
use App\Utilities\CSV\CsvReader;
use Throwable;

/**
 * CsvMovies Importer
 *
 * @version 1.0
 */
class CsvMoviesImporter extends AbstractCsvImporter implements ImporterInterface
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
        $tableData = collect(['table' => 'movies', 'unique' => 'movie_id']);

        foreach (CsvReader::read($file) as $row) {
            $batch[] = MovieTransformer::transform($row);

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
