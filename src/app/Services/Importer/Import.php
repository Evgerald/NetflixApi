<?php

namespace App\Services\Importer;

use App\Utilities\Import\ImportFileManager;

/**
 * Import
 *
 * @version 1.0
 */
readonly class Import
{
    public function __construct(
        private ImportFileManager $importFileManager,
        private ImportDispatcher  $importDispatcher,
    )
    {

    }

    /**
     * @param array $files
     *
     * @return void
     */
    public function import(array $files): void
    {
        $this->importDispatcher->dispatch($this->importFileManager->prepareFiles($files));
    }
}
