<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $table = "periode";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "tahun",
        "aktif_sempro",
        "aktif_sidang_akhir"
    ];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function proposalSemhas(): HasMany
    {
        return $this->hasMany(Proposal::class, 'periode_semhas_id');
    }

    public function visibilitasNilai(): HasMany
    {
        return $this->hasMany(VisibilitasNilai::class);
    }
}
