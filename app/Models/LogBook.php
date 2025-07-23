<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
