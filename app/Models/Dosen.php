<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    protected $table = "dosen";

    protected $fillable = [
        'nidn',
        'nip',
        'nama',
        'email',
        'password',
        'no_handphone',
        'foto_profil',
        'deskripsi_profil',
        'gambar_peminatan_riset',
        'deskripsi_peminatan_riset',
        'publikasi',
        'link_google_scholar',
        'penghargaan'
    ];

    protected $hidden = [
        'remember_token',
    ];

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

    public function listDataDosen()
    {
        return $this->proposalMahasiswas()->get();
    }

    public function bidangMinats(): BelongsToMany
    {
        return $this->belongsToMany(BidangMinat::class, 'dosen_bidang_minat', 'dosen_id', 'bidang_minat_id')
            ->withPivot('status_dosen_bidang_minat_id');
    }

    public function proposalPembimbing1(): HasMany
    {
        return $this->hasMany(Proposal::class, 'dosen_pembimbing_1_id');
    }

    public function proposalPembimbing2(): HasMany
    {
        return $this->hasMany(Proposal::class, 'dosen_pembimbing_2_id');
    }

    public function proposalPengujiSempro1(): HasMany
    {
        return $this->hasMany(JadwalSeminarProposal::class, 'penguji_sempro_1_id');
    }

    public function proposalPengujiSempro2(): HasMany
    {
        return $this->hasMany(JadwalSeminarProposal::class, 'penguji_sempro_2_id');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'dosen_id');
    }
}
