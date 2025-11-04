<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiAkhirMahasiswa extends Model
{
    protected $table = 'nilai_akhir_mahasiswa';
    protected $guarded = ['id'];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosenPembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_1_id');
    }

    public function dosenPembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_2_id');
    }

    public function dosenPenguji1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_1_id');
    }

    public function dosenPenguji2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_2_id');
    }
}
