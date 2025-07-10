<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalSeminarProposal extends Model
{
    protected $table = 'jadwal_seminar_proposal';
    protected $fillable = [
        'proposal_id',
        'ruang',
        'tanggal',
        'sesi',
        'waktu_mulai',
        'waktu_selesai',
        "prodi_id"
    ];
    public $timestamps = false;

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
