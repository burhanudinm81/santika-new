<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DosenBidangMinat extends Model
{
    protected $table = 'dosen_bidang_minat';
    protected $fillable = [
        'dosen_id',
        'bidang_minat_id',
        'status_dosen_bidang_minat_id',
    ];
    public $timestamps = false;

    // Relasi ke Dosen
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi ke BidangMinat
    public function bidangMinat(): BelongsTo
    {
        return $this->belongsTo(BidangMinat::class, 'bidang_minat_id');
    }

    // Relasi ke StatusDosenBidangMinat
    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusDosenBidangMinat::class, 'status_dosen_bidang_minat_id');
    }
}
