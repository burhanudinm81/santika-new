<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahap extends Model
{
    protected $table = "tahap";
    protected $primaryKey = "id";
    protected $keyType = "integer";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "tahap"
    ];

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
