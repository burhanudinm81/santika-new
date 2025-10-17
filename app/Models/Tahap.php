<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahap extends Model
{
    protected $table = "tahap";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "tahap",
        "aktif_sempro",
        "aktif_sidang_akhir"
    ];

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function proposalSemhas(): HasMany
    {
        return $this->hasMany(Proposal::class, 'tahap_semhas_id');
    }

    public function visibilitasNilai(): HasMany
    {
        return $this->hasMany(VisibilitasNilai::class);
    }
}
