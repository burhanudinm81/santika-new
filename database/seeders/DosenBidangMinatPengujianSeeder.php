<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenBidangMinat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenBidangMinatPengujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dosen Aad Hariyadi
        $dosenAadHariyadi = Dosen::firstWhere('nidn', '0004016314');
        DosenBidangMinat::create([
            'dosen_id' => $dosenAadHariyadi->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenAadHariyadi->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Ahmad Wilda
        $dosenAhmadWilda = Dosen::firstWhere('nidn', '0831078402');
        DosenBidangMinat::create([
            'dosen_id' => $dosenAhmadWilda->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Dianthy Marya
        $dosenDianthyMarya = Dosen::firstWhere('nidn', '0026038604');
        DosenBidangMinat::create([
            'dosen_id' => $dosenDianthyMarya->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Azam Muzakhim
        $dosenAzamMuzakhim = Dosen::firstWhere("nidn", "0004056704");
        DosenBidangMinat::create([
            'dosen_id' => $dosenAzamMuzakhim->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenAzamMuzakhim->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen M Junus
        $dosenMochJunus = Dosen::firstWhere("nidn", "0019067203");
        DosenBidangMinat::create([
            'dosen_id' => $dosenMochJunus->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenMochJunus->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Yoyok Heru
        $dosenYoyokHeru = Dosen::firstWhere("nidn", "0008076805");
        DosenBidangMinat::create([
            'dosen_id' => $dosenYoyokHeru->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenYoyokHeru->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Farida Arinie
        $dosenFaridaArinie = Dosen::firstWhere("nidn", "0014046704");
        DosenBidangMinat::create([
            'dosen_id' => $dosenFaridaArinie->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenFaridaArinie->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Hadiwiyatno
        $dosenHadiwiyatno = Dosen::firstWhere("nidn", "0024106303");
        DosenBidangMinat::create([
            'dosen_id' => $dosenHadiwiyatno->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Hendro Darmono
        $dosenHendroDarmono = Dosen::firstWhere('nidn', '0010076213');
        DosenBidangMinat::create([
            'dosen_id' => $dosenHadiwiyatno->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenHadiwiyatno->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Abdul Rasyid
        $dosenAbdulRasyid = Dosen::firstWhere('nidn', '0013036204');
        DosenBidangMinat::create([
            'dosen_id' => $dosenAbdulRasyid->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Hudiono
        $dosenHudiono = Dosen::firstWhere('nidn', '0015016303');
        DosenBidangMinat::create([
            'dosen_id' => $dosenHudiono->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Abdullah Anshori
        $dosenAbdullahAnshori = Dosen::firstWhere("nidn", "0026026305");
        DosenBidangMinat::create([
            'dosen_id' => $dosenAbdullahAnshori->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosene Nugroho Suharto
        $dosenNugrohoSuharto = Dosen::firstWhere("nidn", "0021046205");
        DosenBidangMinat::create([
            'dosen_id' => $dosenNugrohoSuharto->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Koesmarijanto
        $dosenKoesmarijanto = Dosen::firstWhere("nidn", "0003126105");
        DosenBidangMinat::create([
            'dosen_id' => $dosenKoesmarijanto->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Lis Diana
        $dosenLisDiana = Dosen::firstWhere("nidn", "0005057803");
        DosenBidangMinat::create([
            'dosen_id' => $dosenLisDiana->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Nanak Zakaria
        $dosenNanakZakaria = Dosen::firstWhere("nidn", "0011067108");
        DosenBidangMinat::create([
            'dosen_id' => $dosenNanakZakaria->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenNanakZakaria->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 2,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenNanakZakaria->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Mila Kusumawardani
        $dosenMilaKusumawardani = Dosen::firstWhere("nidn", "0001037502");
        DosenBidangMinat::create([
            'dosen_id' => $dosenMilaKusumawardani->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenMilaKusumawardani->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Muhammad Syirajuddin
        $dosenSyirajuddin = Dosen::firstWhere("nidn", "0717108502");
        DosenBidangMinat::create([
            'dosen_id' => $dosenSyirajuddin->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenSyirajuddin->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Nurul Hidayati
        $dosenNurulHidayati = Dosen::firstWhere("nidn", "0008119106");
        DosenBidangMinat::create([
            'dosen_id' => $dosenNurulHidayati->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenNurulHidayati->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Prof Sarosa
        $dosenProfSarosa = Dosen::firstWhere("nidn", "0012016407");
        DosenBidangMinat::create([
            'dosen_id' => $dosenProfSarosa->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Putri Elfa
        $dosenPutriElfa = Dosen::firstWhere("nidn", "0727098603");
        DosenBidangMinat::create([
            'dosen_id' => $dosenPutriElfa->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Rachmad Saptono
        $dosenRachmadSaptono = Dosen::firstWhere("nidn", "0007116607");
        DosenBidangMinat::create([
            'dosen_id' => $dosenRachmadSaptono->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenRachmadSaptono->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Rieke Adriati
        $dosenRiekeAdriati = Dosen::firstWhere("nidn", "0024118302");
        DosenBidangMinat::create([
            'dosen_id' => $dosenRiekeAdriati->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Sri Wahyuni
        $dosenSriWahyuni = Dosen::firstWhere("nidn", "0022067306");
        DosenBidangMinat::create([
            'dosen_id' => $dosenSriWahyuni->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenSriWahyuni->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Rizky Ardiansyah
        $dosenRizkyArdiansyah = Dosen::firstWhere("nidn", "0021129003");
        DosenBidangMinat::create([
            'dosen_id' => $dosenRizkyArdiansyah->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenRizkyArdiansyah->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Adzikirani
        $dosenAdzikirani = Dosen::firstWhere('nidn', '0026079403');
        DosenBidangMinat::create([
            'dosen_id' => $dosenAdzikirani->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenAdzikirani->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Isa Mahfudi
        $dosenIsaMahfudi = Dosen::firstWhere("nidn", "0008089205");
        DosenBidangMinat::create([
            'dosen_id' => $dosenIsaMahfudi->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);

        // Dosen Galih Putra
        $dosenGalihPutra = Dosen::firstWhere("nidn", "0006129005");
        DosenBidangMinat::create([
            'dosen_id' => $dosenGalihPutra->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenGalihPutra->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Atik Novianti
        $dosenAtikNovianti = Dosen::firstWhere("nidn", "0405118901");
        DosenBidangMinat::create([
            'dosen_id' => $dosenAtikNovianti->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenAtikNovianti->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Ginanjar Suwasono Adi
        $dosenGinanjarAdi = Dosen::firstWhere('nidn', '0020089106');
        DosenBidangMinat::create([
            'dosen_id' => $dosenGinanjarAdi->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenGinanjarAdi->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Dodit Suprianto
        $dosenDoditSuprianto = Dosen::firstWhere("nidn", "0716037502");
        DosenBidangMinat::create([
            'dosen_id' => $dosenDoditSuprianto->id,
            'bidang_minat_id' => 2,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenDoditSuprianto->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);

        // Dosen Chandrasena Setiadi
        $dosenChandrasena = Dosen::firstWhere("nidn", "0014038306");
        DosenBidangMinat::create([
            'dosen_id' => $dosenChandrasena->id,
            'bidang_minat_id' => 3,
            'status_dosen_bidang_minat_id' => 1,
        ]);
        DosenBidangMinat::create([
            'dosen_id' => $dosenChandrasena->id,
            'bidang_minat_id' => 1,
            'status_dosen_bidang_minat_id' => 2,
        ]);
    }
}
