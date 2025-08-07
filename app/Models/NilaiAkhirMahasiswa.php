<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAkhirMahasiswa extends Model
{
    protected $table = 'nilai_akhir_mahasiswa';
    protected $guarded = ['id'];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
