<?php

namespace App\Services\Importer\Contracts;

/**
 * Importer Interface
 *
 * @version 1.0
 */
interface ImporterInterface
{
    public const BATCH_SIZE = 1000;

    public function import(string $file);
}
