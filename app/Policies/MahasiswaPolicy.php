<?php

namespace App\Policies;

use App\Models\AdminProdi;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Auth\Access\Response;

class MahasiswaPolicy
{
    public function createMhsD3(AdminProdi $adminProdi): bool
    {
        $prodiD3 = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi");

        return $adminProdi->prodi_id == $prodiD3->id;
    }

    public function createMhsD4(AdminProdi $adminProdi): bool
    {
        $prodiD4 = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");

        return $adminProdi->prodi_id == $prodiD4->id;
    }

    public function deleteMahasiswa(AdminProdi $adminProdi, Mahasiswa $mahasiswa): Response
    {
        return $adminProdi->prodi_id == $mahasiswa->prodi_id
            ? Response::allow()
            : Response::deny("Anda tidak bisa menghapus Mahasiswa Prodi lain");
    }

    public function changePassword(AdminProdi $adminProdi, Mahasiswa $mahasiswa): Response
    {
        return $adminProdi->prodi_id == $mahasiswa->prodi_id
            ? Response::allow()
            : Response::deny("Anda tidak bisa mengganti password Mahasiswa Prodi lain");
    }
}
