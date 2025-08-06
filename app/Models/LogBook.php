<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogBook extends Model
{
    protected $table = 'log_book_skripsi';
    protected $guarded = ['id'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function JenisKegiatanLogbook()
    {
        return $this->belongsTo(JenisKegiatanLogbook::class, 'jenis_kegiatan_id');
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function statusLogbook(): BelongsTo
    {
        return $this->belongsTo(StatusLogbook::class, 'status_logbook_id');
    }
}
