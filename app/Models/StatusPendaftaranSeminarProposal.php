<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPendaftaranSeminarProposal extends Model
{
    protected $table = "status_pendaftaran_seminar_proposal";
    protected $guarded = ["id"];

    public function pendaftaranSempro(): HasMany
    {
        return $this->hasMany(PendaftaranSeminarProposal::class);
    }
}
