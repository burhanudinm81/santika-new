<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProposal extends Model
{
    protected $table = "status_proposal";
    protected $guarded = ["id"];

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function statusSemproPenguji1()
    {
        return $this->hasMany(Proposal::class);
    }

    public function statusSemproPenguji2()
    {
        return $this->hasMany(Proposal::class);
    }

    public function statusSemhasPenguji1()
    {
        return $this->hasMany(Proposal::class);
    }

    public function statusSemhasPenguji2()
    {
        return $this->hasMany(Proposal::class);
    }
}
