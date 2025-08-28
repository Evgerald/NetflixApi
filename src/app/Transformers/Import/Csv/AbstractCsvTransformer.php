<?php

namespace App\Transformers\Import\Csv;

use DateTime;
use Exception;

/**
 * AbstractCsv Transformer
 *
 * @version 1.0
 */
abstract class AbstractCsvTransformer
{
    /**
     * @param string|null $value
     *
     * @return string|null
     */
    protected static function normalizeDate(?string $value): ?string
    {
        try {
            return (new DateTime($value))->format('Y-m-d');
        } catch (Exception) {
            return now()->format('Y-m-d');
        }
    }

    /**
     * @param string|null $value
     *
     * @return string
     */
    protected static function normalizeDateTime(?string $value): string
    {
        try {
            return (new DateTime($value ?? 'now'))->format('Y-m-d H:i:s');
        } catch (Exception) {
            return now()->format('Y-m-d H:i:s');
        }
    }
}
