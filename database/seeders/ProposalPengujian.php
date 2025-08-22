<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalPengujian extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Proposal 1
        Proposal::create([
            'id' => 1,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Implementasi Metode Triliterasi untuk Menentukan Posisi Koordinat Node Sensor pada WSN Menggunakan LoRa",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 2
        Proposal::create([
            'id' => 2,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "IMPLEMENTASI METODE SECOND FOLD RELAY (SFR) SEBAGAI SOLUSI REKONEKSI NODE TERISOLASI DALAM JARINGAN LORA WSN",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 3
        Proposal::create([
            'id' => 3,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 31,
            'judul' => "Perancangan dan Pengembangan Joystick Berbasis LoRa dengan Transmisi Data Terenkripsi untuk Kontrol Motor DC pada Robot Basketball Asia Pasific Broadcasting Union",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 4
        Proposal::create([
            'id' => 4,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 21,
            'judul' => "Prediksi Kepatuhan Konsumsi Obat Pasien Tunanetra Menggunakan Algoritma Naïve Bayes",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 5
        Proposal::create([
            'id' => 5,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 7,
            'judul' => "Manajemen Sistem Perpustakaan Menggunakan Metode Local Binary Pattern Histogram (Studi Kasus BBPPMPV BOE)",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 6
        Proposal::create([
            'id' => 6,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 2,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 18,
            'judul' => "Implementasi Volte dengan Software Open5gs, Srsran dan Kamailio Menggunakan Sdr dengan Sistem Billing",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 7
        Proposal::create([
            'id' => 7,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Implementasi Protokol Extended DE-LEACH pada Sistem Komunikasi LoRa untuk Meningkatkan Lifetime WSN",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 8
        Proposal::create([
            'id' => 8,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 17,
            'judul' => "Perancangan dan Implementasi Jaringan RT/RW Net dengan Teknologi Gigabit Passive Optical Network (GPON) Berbasis Fiber to the Home (FTTH)",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 9
        Proposal::create([
            'id' => 9,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 19,
            'judul' => "Perbandingan Algoritma Cnn (Densnet201, Resnet50, dan Inceptionresnetv2) Pada Alat Klasifikasi Botol Plastik Berdasarkan Jenis Resin",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 10
        Proposal::create([
            'id' => 10,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 20,
            'judul' => "Rancang Bangun Aplikasi Catatan Konseling dan Pelaporan Kemungkinan tindakan Bullying Menggunakan Naïve Bayes (Studi Kasus: SMKN 1 Pungging Mojokerto)",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 11
        Proposal::create([
            'id' => 11,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 27,
            'judul' => "Rancang Bangun Alat Indikator Komunikasi antar Pendaki Gunung Berbasis LoRa",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 12
        Proposal::create([
            'id' => 12,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 20,
            'judul' => "Pengembangan Alat Pembasmi Hama Portabel Berbasis Internet of Things Menggunakan Kamera sebagai Pemantau",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 13
        Proposal::create([
            'id' => 13,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 27,
            'judul' => "Rancang Bangun Pengiriman Data Suara sebagai Komunikasi antar Pendaki Gunung Berbasis Lora",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 14
        Proposal::create([
            'id' => 14,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Pengaturan Beban Cluster Head pada Sistem Komunikasi LoRa untuk Stabilitas Wireless Sensor Network",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 15
        Proposal::create([
            'id' => 15,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 19,
            'judul' => "Implementasi Protokol MQTT dengan Keamanan SSL/TLS pada Sistem Peringatan Dini Gempa di Wilayah Zona Megathrust berbasis IoT",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 16
        Proposal::create([
            'id' => 16,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Implementasi Protokol PC-LEACH Menggunakan Algoritma Clustering Hierarkis Adaptif pada Wireless Sensor Network Berbasis LoRa dengan Distance Aware Routing Protocol",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 17
        Proposal::create([
            'id' => 17,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 5,
            'judul' => "Algoritma K-Nearest Neighbour (KNN) untuk Integrasi Sistem Monitoring dan Controlling dalam Pengolahan Gas Metana sebagai Energi Terbarukan dari Limbah Sayuran",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 18
        Proposal::create([
            'id' => 18,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Pemanfaatan Metode Silhouette - Leach dalam Sistem Komunikasi LoRa untuk Meningkatkan Throughput Jaringan WSN",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 19
        Proposal::create([
            'id' => 19,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 31,
            'judul' => "Pengembangan Arm Robot Multi-DOF Autonomous dengan Kemampuan Gripping Berbasis IoRT dan Deteksi Citra CNN Menggunakan Inverse Kinematics",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 20
        Proposal::create([
            'id' => 20,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 5,
            'judul' => "Implementasi Algoritma Support Vector Machine Sebagai Sistem Pemantauan Kualitas Udara Rumah dengan Air Purifier Cerdas untuk Menjaga Kesehatan dan Kenyamanan Penghuni",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 21
        Proposal::create([
            'id' => 21,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 15,
            'judul' => "E-Smart PJU Berbasis Website yang Terintegrasi dengan Google Maps API",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 22
        Proposal::create([
            'id' => 22,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 5,
            'judul' => "Algoritma K-Means Clustering untuk Sistem Monitoring dan Controlling Cerdas dalam Pengolahan Jerami Padi Menjadi Biogas",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 23
        Proposal::create([
            'id' => 23,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 5,
            'judul' => "Algoritma Jaringan Syaraf Tiruan (ANN) Pada Sistem Kontrol Optimalisasi Kualitas Udara Di Tempat Pembuangan Sampah Teknologi Eco-Enzim",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 24
        Proposal::create([
            'id' => 24,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 21,
            'judul' => "Rancang Bangun Smart Packet Box Cash on Delivery (COD) Berbasis Aplikasi Android",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 25
        Proposal::create([
            'id' => 25,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 12,
            'judul' => "Rancang Bangun Sistem Persewaan Loker Berbasis IoT dengan Integrasi GPS dan Android (Studi Kasus: Warung Watu Konang, Sumber Maron)",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 26
        Proposal::create([
            'id' => 26,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 29,
            'judul' => "Implementasi Gelang Cerdas Pendeteksi Stres Menggunakan Logika Fuzzy Mamdani",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 27
        Proposal::create([
            'id' => 27,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 6,
            'judul' => "Implementasi Kinerja Protokol REACT-LEACH pada Sistem Komunikasi LoRa dalam Wireless Sensor Network",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 28
        Proposal::create([
            'id' => 28,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 9,
            'judul' => "Pengembangan Rancang Bangun Sistem Telecontrolling Antena Rotator Elevasi dan Azimuth untuk Praktikum di Politeknik Negeri Malang",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 29
        Proposal::create([
            'id' => 29,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 1,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 20,
            'judul' => "Sistem IoT pada Penyiram dan Pemantau Tanaman Jagung Untuk Pakan Kelinci Pedaging Berbasis YOLOv5",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);

        // Proposal 30
        Proposal::create([
            'id' => 30,
            'prodi_id' => 2,
            'periode_id' => 1,
            'bidang_minat_id' => 3,
            'jenis_judul_id' => 1,
            'dosen_pembimbing_1_id' => 7,
            'judul' => "Sistem Keamanan Ruangan Indoor dan Outdoor Menggunakan Algoritma LBPH (Studi Kasus: Politeknik Negeri Malang)",
            'topik' => fake()->sentence(),
            'tujuan' => fake()->sentence(),
            'latar_belakang' => fake()->sentence(),
            'blok_diagram_sistem' => fake()->sentence(),
            'tahap_id' => 2,
        ]);
    }
}
