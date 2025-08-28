<?php

namespace App\Factories\Import;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Services\Importer\Csv\CsvUsersImporter;
use InvalidArgumentException;

/**
 * UsersImporter Factory
 *
 * @version 1.0
 */
class UsersImporterFactory
{
    /**
     * @param string $file
     *
     * @return ImporterInterface
     */
    public function make(string $file): ImporterInterface
    {
        $format = pathinfo($file, PATHINFO_EXTENSION);

        return match ($format) {
            'csv' => new CsvUsersImporter(),
            default => throw new InvalidArgumentException("Unknown import type: {$format}"),
        };
    }
}
