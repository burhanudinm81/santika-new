<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusDosenBidangMinat extends Model
{
    protected $table = 'status_dosen_bidang_minat';
    protected $fillable = [
        'status',
    ];
    public $timestamps = false;

    public function dosenBidangMinat(): HasMany
    {
        return $this->hasMany(DosenBidangMinat::class, 'status_dosen_bidang_minat_id');
    }
}
