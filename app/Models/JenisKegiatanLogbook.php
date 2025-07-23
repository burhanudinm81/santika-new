<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKegiatanLogbook extends Model
{
    protected $table = 'jenis_kegiatan_logbook';
    protected $guarded = ['id'];

    public function logbooks()
    {
        return $this->hasMany(LogBook::class, 'jenis_kegiatan_id');
    }
}
