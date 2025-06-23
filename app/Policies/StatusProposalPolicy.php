<?php

namespace App\Policies;

use App\Models\AdminProdi;
use App\Models\StatusProposal;
use Illuminate\Auth\Access\Response;

class StatusProposalPolicy
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
    public function view(AdminProdi $adminProdi, StatusProposal $statusProposal): bool
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
    public function update(AdminProdi $adminProdi, StatusProposal $statusProposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AdminProdi $adminProdi, StatusProposal $statusProposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AdminProdi $adminProdi, StatusProposal $statusProposal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AdminProdi $adminProdi, StatusProposal $statusProposal): bool
    {
        return false;
    }
}
