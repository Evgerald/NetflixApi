<?php

namespace App\Console\Commands;

use App\Services\Importer\Import;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Import Command
 *
 * @version 1.0
 */
class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:files {files*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import files.';

    public function __construct(private readonly Import $import)
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $files = $this->argument('files');

        if (empty($files)) {
            $this->error('No files provided for import.');

            return SymfonyCommand::FAILURE;
        }

        $this->info('Importing files...');

        try {
            $this->import->import($files);
            $this->info('All files are successfully put in job(s).');
        } catch (Exception $e) {
            $this->error('Error occurred while importing files: ' . $e->getMessage());

            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }
}
