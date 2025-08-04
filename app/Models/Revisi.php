<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = "revisi";
    protected $guarded = ["id"];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, "proposal_id");
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, "dosen_id");
    }
}
