<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSeminarHasil extends Model
{
    use HasFactory;

    protected $table = 'jadwal_seminar_hasil';

    protected $fillable = [
        'proposal_id',
        'ruang',
        'tanggal',
        'sesi',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
