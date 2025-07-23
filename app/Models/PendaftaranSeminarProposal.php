<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PendaftaranSeminarProposal extends Model
{
    protected $table = "pendaftaran_seminar_proposal";
    protected $guarded = ["id"];

    public function statusDaftarSempro(): BelongsTo
    {
        return $this->belongsTo(StatusPendaftaranSeminar::class, 'status_daftar_sempro_id');
    }

    public function hasProposalFile()
    {
        return $this->file_proposal && Storage::disk('local')->exists($this->file_proposal);
    }

    public function getPathProposalFile()
    {
        if ($this->file_proposal) {
            return route('proposal-sempro.show', $this->id);
        }
        return null;
    }

    public function hasLembarKonsultasi()
    {
        return $this->lembar_konsultasi && Storage::disk('local')->exists($this->lembar_konsultasi);
    }

    public function getPathLembarKonsultasiFile()
    {
        if ($this->lembar_konsultasi) {
            return route('lembar-konsul.show', $this->id);
        }
        return null;
    }

    public function hasLembarKerjaSamaMitra()
    {
        return $this->lembar_kerjasama_mitra && Storage::disk('local')->exists($this->lembar_kerjasama_mitra);
    }

    public function getPathLembarKerjaSamaMitraFile()
    {
        if ($this->lembar_kerjasama_mitra) {
            return route('lembar-kerjasama-mitra.show', $this->id);
        }
        return null;
    }

    public function hasBuktiCekPlagiasi()
    {
        return $this->bukti_cek_plagiasi && Storage::disk('local')->exists($this->bukti_cek_plagiasi);
    }

    public function getPathBuktiCekPlagiasiFile()
    {
        if ($this->bukti_cek_plagiasi) {
            return route('bukti-cek-plagiasi.show', $this->id);
        }
        return null;
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
