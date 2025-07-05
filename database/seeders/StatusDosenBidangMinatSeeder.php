<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\StatusDosenBidangMinat;

class StatusDosenBidangMinatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status1 = new StatusDosenBidangMinat();
        $status1->status = 'Bidang Minat 1';
        $status1->save();

        $status2 = new StatusDosenBidangMinat();
        $status2->status = 'Bidang Minat 2';
        $status2->save();
         
        $status3 = new StatusDosenBidangMinat();
        $status3->status = 'Bidang Minat 3';
        $status3->save();
    }
}
