<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuotaDosen extends Model
{
    protected $table = "kuota_dosen";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }
}
