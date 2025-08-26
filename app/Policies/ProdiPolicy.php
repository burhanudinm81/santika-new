<?php

namespace App\Policies;

use App\Models\AdminProdi;
use App\Models\Prodi;

class ProdiPolicy
{
    public function createPanitia(AdminProdi $adminProdi, Prodi $prodi): bool
    {
        return $adminProdi->prodi_id == $prodi->id;
    }

    public function editPanitia(AdminProdi $adminProdi, Prodi $prodi): bool
    {
        return $adminProdi->prodi_id == $prodi->id;
    }
}
