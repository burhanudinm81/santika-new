<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPembandingPlagiasi extends Model
{
    protected $table = 'dokumen_pembanding_plagiasi';

    protected $fillable = [
        'filename',
        'file_path',
        'nama_mahasiswa_1',
        'nim_1'
    ];
}
