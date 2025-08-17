<?php

namespace App\Jobs;

use App\Services\DosenImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessDosenImport implements ShouldQueue
{
    use Queueable;

    protected $filepath;
    protected $filename;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filepath, string $filename)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
    }


    /**
     * Execute the job.
     */
    public function handle(DosenImportService $dosenImportService): void
    {
        $dosenImportService->import(
            $this->filepath,
            $this->filename
        );
    }
}
