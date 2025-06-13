<?php

namespace App\Policies;

use App\Models\AdminProdi;
use App\Models\Prodi;

class MahasiswaPolicy
{
    public function createMhsD3(AdminProdi $adminProdi): bool
    {
        $prodiD3 = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi");

        return $adminProdi->prodi_id === $prodiD3->id;
    }

    public function createMhsD4(AdminProdi $adminProdi): bool
    {
        $prodiD4 = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");

        return $adminProdi->prodi_id === $prodiD4->id;
    }
}
