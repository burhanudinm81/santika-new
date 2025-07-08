<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangMinat extends Model
{
    protected $table = "bidang_minat";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "bidang_minat"
    ];


    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function dosen(): BelongsToMany
    {
        return $this->belongsToMany(
            Dosen::class,
            'dosen_bidang_minat',
            'bidang_minat_id',
            'dosen_id'
        )->withPivot('status_dosen_bidang_minat_id');
    }
}
