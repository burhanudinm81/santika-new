<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminProdi extends Authenticatable
{
    protected $table = "admin_prodi";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}
