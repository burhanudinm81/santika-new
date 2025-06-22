<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranSeminarProposal extends Model
{
    protected $table = "pendaftaran_seminar_proposal";
    protected $guarded = ["id"];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
