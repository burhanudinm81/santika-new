<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prodi extends Model
{
    protected $table = "prodi";
    protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "prodi"
    ];

    public function adminProdi(): HasOne
    {
        return $this->hasOne(AdminProdi::class);
    }

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function panitia(): HasMany
    {
        return $this->hasMany(Panitia::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
