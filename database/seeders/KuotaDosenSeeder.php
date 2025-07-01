<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\KuotaDosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KuotaDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosen1 = Dosen::firstWhere("nidn", "20021001001");
        $dosen2 = Dosen::firstWhere("nidn", "20021001002");
        $dosen3 = Dosen::firstWhere("nidn", "20021001003");
        $dosen4 = Dosen::firstWhere("nidn", "20021001004");
        $dosen5 = Dosen::firstWhere("nidn", "20021001005");
        $dosen6 = Dosen::firstWhere("nidn", "20021001006");
        $dosen7 = Dosen::firstWhere("nidn", "20021001007");
        $dosen8 = Dosen::firstWhere("nidn", "20021001008");
        $dosen9 = Dosen::firstWhere("nidn", "20021001009");
        $dosen10 = Dosen::firstWhere("nidn", "20021001010");

        $kuotaDosen1 = new KuotaDosen();
        $kuotaDosen2 = new KuotaDosen();
        $kuotaDosen3 = new KuotaDosen();
        $kuotaDosen4 = new KuotaDosen();
        $kuotaDosen5 = new KuotaDosen();
        $kuotaDosen6 = new KuotaDosen();
        $kuotaDosen7 = new KuotaDosen();
        $kuotaDosen8 = new KuotaDosen();
        $kuotaDosen9 = new KuotaDosen();
        $kuotaDosen10 = new KuotaDosen();

        $dosen1->kuotaDosen()->save($kuotaDosen1);
        $dosen2->kuotaDosen()->save($kuotaDosen2);
        $dosen3->kuotaDosen()->save($kuotaDosen3);
        $dosen4->kuotaDosen()->save($kuotaDosen4);
        $dosen5->kuotaDosen()->save($kuotaDosen5);
        $dosen6->kuotaDosen()->save($kuotaDosen6);
        $dosen7->kuotaDosen()->save($kuotaDosen7);
        $dosen8->kuotaDosen()->save($kuotaDosen8);
        $dosen9->kuotaDosen()->save($kuotaDosen9);
        $dosen10->kuotaDosen()->save($kuotaDosen10);
    }
}
