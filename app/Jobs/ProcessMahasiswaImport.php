<?php

namespace App\Jobs;

use App\Exceptions\ImportDataException;
use App\Models\Mahasiswa;
use App\Services\MahasiswaImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ProcessMahasiswaImport implements ShouldQueue
{
    use Queueable;

    protected $filepath;
    protected $filename;
    protected $prodiId;
    protected $periodeId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filepath, string $filename, int $prodiId, int $periodeId)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
        $this->prodiId = $prodiId;
        $this->periodeId = $periodeId;
    }

    /**
     * Execute the job.
     */
    public function handle(MahasiswaImportService $mahasiswaImportService): void
    {
        $mahasiswaImportService->import(
            $this->filepath,
            $this->filename,
            $this->prodiId,
            $this->periodeId
        );
    }
}
