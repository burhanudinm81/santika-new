<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisibilitasNilai extends Model
{
    /*
    visibilitas_nilai
    -id
    -periode_id
    -tahap_id
    -jenis_nilai_seminar (int)
    -visibilitas (boolean)

    Jenis Seminar
    1 -> Status Kelulusan Seminar Proposal
    2 -> Nilai Sidang Tugas Akhir
    */
    protected $table = "visibilitas_nilai";
    protected $guarded = ["id"];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function tahap(): BelongsTo
    {
        return $this->belongsTo(Tahap::class, 'tahap_id');
    }
}
