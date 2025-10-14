<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = "notifikasi";

    protected $fillable = [
        "keterangan",
        "mahasiswa_id",
        "dosen_id",
        "tipe",
    ];
}
