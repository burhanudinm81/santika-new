<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = "revisi";
    protected $guarded = ["id"];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, "proposal_id");
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, "dosen_id");
    }

    public function getPathRevisiProposalSempro()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-sempro.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSempro()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-sempro.show', $this->id);
        }
        return null;
    }

    public function getPathRevisiProposalSemhas()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-semhas.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSemhas()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-semhas.show', $this->id);
        }
        return null;
    }

    // untuk dosen
    public function getPathRevisiProposalSemproForDosen()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-sempro-dosen.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSemproForDosen()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-sempro-dosen.show', $this->id);
        }
        return null;
    }

    public function getPathRevisiProposalSemhasForDosen()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-semhas-dosen.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSemhasForDosen()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-semhas-dosen.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSemproForMhs()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-sempro-mhs.show', $this->id);
        }
        return null;
    }

    public function getPathRevisiProposalSemproForMhs()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-sempro-mhs.show', $this->id);
        }
        return null;
    }

    public function getPathLembarRevisiSemhasForMhs()
    {
        if ($this->file_lembar_revisi_dosen) {
            return route('revisi-lembarRevisi-semhas-mhs.show', $this->id);
        }
        return null;
    }

    public function getPathRevisiProposalSemhasForMhs()
    {
        if ($this->file_proposal_revisi) {
            return route('revisi-proposal-semhas-mhs.show', $this->id);
        }
        return null;
    }
}
