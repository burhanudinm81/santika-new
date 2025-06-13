<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JabatanPanitia extends Model
{
    protected $table = "jabatan_panitia";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    public function panitia(): HasMany
    {
        return $this->hasMany(Panitia::class);
    }
}
