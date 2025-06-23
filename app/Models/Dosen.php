<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    protected $table = "dosen";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function panitia(): HasOne
    {
        return $this->hasOne(Panitia::class);
    }

    public function kuotaDosen(): HasOne
    {
        return $this->hasOne(KuotaDosen::class);
    }
}
