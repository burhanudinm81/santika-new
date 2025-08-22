<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenPengujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'id' => 1,
            "nidn" => "0004016314",
            "nama" => "AAD HARIYADI, S.ST., M.T.",
            "nip" => "196301041988031002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 2,
            "nidn" => "0831078402",
            "nama" => "AHMAD WILDA YULIANTO, S.T., M.T.",
            "nip" => "198407312019031008",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 3,
            "nidn" => "0026038604",
            "nama" => "DIANTHY MARYA, S.T., M.T.",
            "nip" => "198603262019032011",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 4,
            "nidn" => "0004056704",
            "nama" => "Dr. Ir. AZAM MUZAKHIM IMAMMUDDIN, M.T.",
            "nip" => "196705041994031004",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 5,
            "nidn" => "0019067203",
            "nama" => "Dr. MOCHAMMAD JUNUS, S.T., M.T.",
            "nip" => "197206191999031002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 6,
            "nidn" => "0008076805",
            "nama" => "Drs. YOYOK HERU PRASETYO ISONOMO, M.T.",
            "nip" => "196807081994031002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 7,
            "nidn" => "0014046704",
            "nama" => "Dr. FARIDA ARINIE SOELISTIANI, S.T., M.T.",
            "nip" => "196704141993032002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 8,
            "nidn" => "0024106303",
            "nama" => "HADIWIYATNO, S.T., M.T.",
            "nip" => "196310241988031002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 9,
            "nidn" => "0010076213",
            "nama" => "HENDRO DARMONO, B.ENG., M.T.",
            "nip" => "196207101991031003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 10,
            "nidn" => "0013036204",
            "nama" => "Ir. ABDUL RASYID, M.T.",
            "nip" => "196203131994031001",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 11,
            "nidn" => "0015016303",
            "nama" => "Ir. HUDIONO, M.T.",
            "nip" => "196301151988111001",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 12,
            "nidn" => "0026026305",
            "nama" => "Ir. MOH. ABDULLAH ANSHORI, M.MT.",
            "nip" => "196302261988031001",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 13,
            "nidn" => "0021046205",
            "nama" => "Ir. NUGROHO SUHARTO, M.T.",
            "nip" => "196204211989031001",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 14,
            "nidn" => "0003126105",
            "nama" => "KOESMARIJANTO, S.T., M.T.",
            "nip" => "196112031985031005",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 15,
            "nidn" => "0005057803",
            "nama" => "LIS DIANA MUSTAFA, S.T., M.T.",
            "nip" => "197805052001122003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 16,
            "nidn" => "0011067108",
            "nama" => "M. NANAK ZAKARIA, S.T., M.T.",
            "nip" => "197106111999031004",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 17,
            "nidn" => "0001037502",
            "nama" => "MILA KUSUMAWARDANI, S.T., M.T.",
            "nip" => "197503012000032002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 18,
            "nidn" => "0717108502",
            "nama" => "MUHAMMAD SYIRAJUDDIN S., S.T., M.T",
            "nip" => "198510172019031009",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 19,
            "nidn" => "0008119106",
            "nama" => "NURUL HIDAYATI, S.T., M.T.",
            "nip" => "199111082019032017",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 20,
            "nidn" => "0012016407",
            "nama" => "Prof. Dr. MOECHAMMAD SAROSA, DIPL.ING.,M.T.",
            "nip" => "196401121992031002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 21,
            "nidn" => "0727098603",
            "nama" => "PUTRI ELFA MAS'UDIA, S.T., M.CS.",
            "nip" => "198609272012122003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 22,
            "nidn" => "0007116607",
            "nama" => "RACHMAD SAPTONO, S.T., M.T.",
            "nip" => "196611071990031003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 23,
            "nidn" => "0024118302",
            "nama" => "RIEKE ADRIATI WIJAYANTI, S.T., M.T.",
            "nip" => "198311242019032006",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 24,
            "nidn" => "0022067306",
            "nama" => "Ir. SRI WAHYUNI DALI, S.T., M.T.",
            "nip" => "197306221999032002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 25,
            "nidn" => "0021129003",
            "nama" => "RIZKY ARDIANSYAH, S.KOM., M.T.",
            "nip" => "199012212022031005",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 26,
            "nidn" => "0026079403",
            "nama" => "ADZIKIRANI, S.S.T., M.Tr.T.",
            "nip" => "199407262022031009",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 27,
            "nidn" => "0008089205",
            "nama" => "ISA MAHFUDI, S.S.T., M.Tr.T",
            "nip" => "199208082023211019",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 28,
            "nidn" => "0006129005",
            "nama" => "GALIH PUTRA RIATMA, S.ST., M.T.",
            "nip" => "199012062020121003",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 29,
            "nidn" => "0405118901",
            "nama" => "ATIK NOVIANTI, S.ST., M.T.",
            "nip" => "198911052022032014",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 30,
            "nidn" => "0020089106",
            "nama" => "GINANJAR SUWASONO ADI, S.ST., M.Sc.",
            "nip" => "199108202019031009",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 31,
            "nidn" => "0716037502",
            "nama" => "DODIT SUPRIANTO, S.KOM., M.T.",
            "nip" => "197503162023211002",
            "password" => Hash::make("password123")
        ]);

        Dosen::create([
            'id' => 32,
            "nidn" => "0014038306",
            "nama" => "CHANDRASENA SETIADI, S.T., M.Tr.T.",
            "nip" => "198303142024211001",
            "password" => Hash::make("password123")
        ]);
    }
}
