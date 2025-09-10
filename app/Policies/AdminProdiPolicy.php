<?php

namespace App\Policies;

use App\Models\AdminProdi;

class AdminProdiPolicy
{
    public function updateProfile(AdminProdi $adminProdi){
        return $adminProdi->id == auth()->id();
    }
}
