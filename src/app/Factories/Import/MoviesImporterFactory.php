<?php

namespace App\Factories\Import;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Services\Importer\Csv\CsvMoviesImporter;
use InvalidArgumentException;

/**
 * MoviesImporter Factory
 *
 * @version 1.0
 */
class MoviesImporterFactory
{
    /**
     * @param string $file
     *
     * @return ImporterInterface
     *
     * @throws InvalidArgumentException
     */
    public function make(string $file): ImporterInterface
    {
        $format = pathinfo($file, PATHINFO_EXTENSION);

        return match ($format) {
            'csv' => new CsvMoviesImporter(),
            default => throw new InvalidArgumentException("Unknown import type: $format"),
        };
    }
}
