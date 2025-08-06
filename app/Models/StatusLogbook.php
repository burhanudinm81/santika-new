<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusLogbook extends Model
{
    protected $table = 'status_logbook';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'status'
    ];

    public function logbooks(): HasMany
    {
        return $this->hasMany(LogBook::class, 'status_logbook_id');
    }
}
