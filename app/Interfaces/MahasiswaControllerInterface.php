<?php

namespace App\Interfaces;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\View\View;

interface MahasiswaControllerInterface
{
    public function showMahasiswaPage(): View;
    public function showAllMahasiswa();
    public function searchMahasiswa(Request $request);
    public function importMahasiswa(Request $request);
}
