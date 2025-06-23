<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisJudul extends Model
{
    protected $table = "jenis_judul";
    protected $guarded = ['id'];


    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
