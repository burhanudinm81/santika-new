<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranSemhas extends Model
{
    protected $table = 'pendaftaran_seminar_hasil';
    protected $guarded = ['id'];

    public function statusDaftarSeminar(): BelongsTo
    {
        return $this->belongsTo(StatusPendaftaranSeminar::class, 'status_daftar_semhas_id');
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function getPathSuratRekom()
    {
        if ($this->file_rekom_dospem) {
            return route('surat-rekom.show', $this->id);
        }
        return null;
    }

    public function getPathProposalSemhas()
    {
        if ($this->file_proposal_semhas) {
            return route('proposal-semhas.show', $this->id);
        }
        return null;
    }

    public function getPathDraftJurnal()
    {
        if ($this->file_draft_jurnal) {
            return route('draft-jurnal.show', $this->id);
        }
        return null;
    }

    public function getPathIAMitra()
    {
        if ($this->file_IA_mitra) {
            return route('ia-mitra.show', $this->id);
        }
        return null;
    }

    public function getPathBebasTanggunganPkl()
    {
        if ($this->file_bebas_tanggungan_pkl) {
            return route('bebas-pkl.show', $this->id);
        }
        return null;
    }

    public function getPathSkla()
    {
        if ($this->file_skla) {
            return route('skla.show', $this->id);
        }
        return null;
    }
}
