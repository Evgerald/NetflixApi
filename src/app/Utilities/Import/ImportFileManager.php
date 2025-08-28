<?php

namespace App\Utilities\Import;

/**
 * ImportFile Manager
 *
 * Utility for preparing files to import
 *
 * @version 2.0
 *
 * @since version 2.0 method sortByPriority() was removed
 */
class ImportFileManager
{
    private array $files;

    /**
     * @param array $files
     *
     * @return array
     */
    public function prepareFiles(array $files): array
    {
        $this->files = $files;
        $this->filterByFormat()->removeDuplicates()->removeNotAllowed();

        return $this->files;
    }

    /**
     * @return $this
     */
    private function filterByFormat(): static
    {
        $allowedFormats = config('import.allowed_formats');

        $this->files = array_filter($this->files, function ($file) use ($allowedFormats) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            return in_array($ext, $allowedFormats, true);
        });

        return $this;
    }

    /**
     * @return $this
     */
    private function removeDuplicates(): static
    {
        $this->files = array_values(array_unique($this->files));

        return $this;
    }

    /**
     * @return $this
     */
    private function removeNotAllowed(): static
    {
        $allowed = config('import.allowed_files_sorted_by_priority');

        $this->files = array_filter($this->files, function ($file) use ($allowed) {
            $name = pathinfo($file, PATHINFO_FILENAME);

            return in_array($name, $allowed, true);
        });

        return $this;
    }
}
