<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPendaftaranSeminar extends Model
{
    protected $table = "status_pendaftaran_seminar";
    protected $guarded = ["id"];

    public function pendaftaranSempro(): HasMany
    {
        return $this->hasMany(PendaftaranSeminarProposal::class);
    }

    public function pendaftaranSemhas(): HasMany
    {
        return $this->hasMany(PendaftaranSemhas::class);
    }
}
