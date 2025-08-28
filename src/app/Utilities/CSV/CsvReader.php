<?php

namespace App\Utilities\CSV;

/**
 * Csv Reader
 *
 * @version 1.0
 */
class CsvReader
{
    /**
     * @param string $filePath
     * @param string $delimiter
     * @return \Generator
     */
    public static function read(string $filePath, string $delimiter = ','): \Generator
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("CSV file not found: {$filePath}");
        }

        if (($handle = fopen($filePath, 'r')) === false) {
            throw new \RuntimeException("Cannot open file: {$filePath}");
        }

        $header = fgetcsv($handle, 0, $delimiter);
        if ($header === false) {
            fclose($handle);

            return;
        }

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (count($row) !== count($header)) {
                continue;
            }

            yield array_combine($header, $row);
        }

        fclose($handle);
    }
}
