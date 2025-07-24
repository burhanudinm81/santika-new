<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    protected $table = "mahasiswa";
    protected $guarded = ["id", "password", "remember_token"];
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function proposalMahasiswas(): HasMany
    {
        return $this->hasMany(ProposalDosenMahasiswa::class);
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(LogBook::class, 'mahasiswa_id');
    }
}
