<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalDosenMahasiswa extends Model
{
    protected $table = "proposal_dosen_mahasiswa";
    protected $guarded = ["id"];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function statusProposalMahasiswa(): BelongsTo
    {
        return $this->belongsTo(StatusProposalMahasiswa::class);
    }
}
