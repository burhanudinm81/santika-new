<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    protected $table = "dosen";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function panitia(): HasOne
    {
        return $this->hasOne(Panitia::class);
    }

    public function kuotaDosen(): HasOne
    {
        return $this->hasOne(KuotaDosen::class);
    }
    public function proposalMahasiswas(): HasMany
    {
        return $this->hasMany(ProposalDosenMahasiswa::class);
    }

    public function bidangMinats(): BelongsToMany
    {
        return $this->belongsToMany(BidangMinat::class, 'dosen_bidang_minat', 'dosen_id', 'bidang_minat_id')
            ->withPivot('status_dosen_bidang_minat_id');
    }
}
