<?php

namespace App\Policies;

use App\Models\AdminProdi;
use App\Models\NilaiSemhas;
use Illuminate\Auth\Access\Response;

class NilaiSemhasPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AdminProdi $adminProdi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AdminProdi $adminProdi, NilaiSemhas $nilaiSemhas): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AdminProdi $adminProdi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AdminProdi $adminProdi, NilaiSemhas $nilaiSemhas): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AdminProdi $adminProdi, NilaiSemhas $nilaiSemhas): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AdminProdi $adminProdi, NilaiSemhas $nilaiSemhas): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AdminProdi $adminProdi, NilaiSemhas $nilaiSemhas): bool
    {
        return false;
    }
}
