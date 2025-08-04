<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Proposal extends Model
{
    protected $table = "proposal";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    // helper untuk mendapatkan url diagram
    public function getBlokDiagramUrlAttribute()
    {
        if ($this->blok_diagram_sistem) {
            return route('blok.diagram.show', $this->id);
        }
        return null;
    }

    public function hasBlokDiagram()
    {
        return $this->blok_diagram_sistem && Storage::disk('local')->exists($this->blok_diagram_sistem);
    }

    public function getBlokDiagramNameAttribute()
    {
        if ($this->blok_diagram_sistem) {
            return basename($this->blok_diagram_sistem);
        }

        return null;
    }

    public function proposalMahasiswas(): HasMany
    {
        return $this->hasMany(ProposalDosenMahasiswa::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function tahap(): BelongsTo
    {
        return $this->belongsTo(Tahap::class);
    }

    public function jenisJudul(): BelongsTo
    {
        return $this->belongsTo(JenisJudul::class);
    }

    public function bidangMinat(): BelongsTo
    {
        return $this->belongsTo(BidangMinat::class);
    }

    public function pendaftaranSempro(): HasOne
    {
        return $this->hasOne(PendaftaranSeminarProposal::class);
    }

    public function pendaftaranSemhas(): HasOne
    {
        return $this->hasOne(PendaftaranSemhas::class);
    }

    public function jadwalSeminarProposals(): HasMany
    {
        return $this->hasMany(JadwalSeminarProposal::class, 'proposal_id');
    }

    public function jadwalSeminarProposal()
    {
        return $this->hasOne(JadwalSeminarProposal::class, 'proposal_id');
    }

    public function dosenPembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_1_id');
    }
    public function dosenPembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_2_id');
    }
    public function dosenPengujiSempro1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_sempro_1_id');
    }
    public function dosenPengujiSempro2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_sempro_2_id');
    }
    public function dosenPengujiSidangTA1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_sidang_ta_1_id');
    }
    public function dosenPengujiSidangTA2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'penguji_sidang_ta_2_id');
    }
    public function proposalSemhas(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_semhas_id');
    }
    public function tahapSemhas(): BelongsTo
    {
        return $this->belongsTo(Tahap::class, 'tahap_semhas_id');
    }
    public function jadwalSeminarHasil(): HasOne
    {
        return $this->hasOne(JadwalSeminarHasil::class, 'proposal_id');
    }
}
