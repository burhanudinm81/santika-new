<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
