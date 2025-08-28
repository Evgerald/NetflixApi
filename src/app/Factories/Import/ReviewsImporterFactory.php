<?php

namespace App\Factories\Import;

use App\Services\Importer\Contracts\ImporterInterface;
use App\Services\Importer\Csv\CsvReviewImporter;
use InvalidArgumentException;

/**
 * ReviewsImporter Factory
 *
 * @version 1.0
 */
class ReviewsImporterFactory
{
    public function make(string $file): ImporterInterface
    {
        $format = pathinfo($file, PATHINFO_EXTENSION);

        return match ($format) {
            'csv' => new CsvReviewImporter(),
            default => throw new InvalidArgumentException("Unknown import type: {$format}"),
        };
    }
}
