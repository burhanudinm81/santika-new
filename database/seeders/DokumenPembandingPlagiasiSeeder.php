<?php

namespace Database\Seeders;

use App\Models\DokumenPembandingPlagiasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenPembandingPlagiasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dokumen 1-10
        $doc1 = DokumenPembandingPlagiasi::create([
            'filename' => "BAB 1 APLIKASI PAKAN OTOMATIS DAN SISTEM KONTROL MONITORING PH DAN SUHU PADA IKAN GLOFISH DENGAN METODE FUZZY MAMDANI",
            'nama_mahasiswa_1' => 'DYTTO ARDJIONO',
            "nim_1" => '2041160126',
        ]);

        $doc2 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN KOTAK OBAT BERBASIS SUARA BAGI PASIEN TUNANETRA',
            'nama_mahasiswa_1' => 'MUHAMMAD AQMAL IMAN PRAKASA',
            "nim_1" => '2041160128'
        ]);
        $doc3 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGEMBANGAN SISTEM APLIKASI PENGECEKAN METERAN AIR PDAM RUMAH TANGGA BERBASIS OPTICAL CHARACTER RECOGNITION (OCR) PADA JARINGAN LORAWAN',
            'nama_mahasiswa_1' => 'YAYANG UYUNURROHMA ',
            "nim_1" => '2041160046'
        ]);
        $doc4 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM CERDAS UNTUK MEMPREDIKSI KESEHATAN PARU – PARU DENGAN ALGORITMA K – NEAREST NEIGHBORS PADA PLATFORM INTERNET OF MEDICAL THINGS',
            'nama_mahasiswa_1' => 'TEGAR HARDIANSYAH',
            "nim_1" => '2041160099'
        ]);
        $doc5 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM KONTROL OTOMATIS ANTENA YAGI 433 Mhz untuk STASIUN PENGAMATAN Radiosonde BERBASIS ANDROID',
        ]);
        $doc6 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SMART AGRO SYSTEM PADA BUDIDAYA TANAMAN KRISAN DI DAERAH TANPA INTERNET MENGGUNAKAN KOMUNIKASI BLUETOOTH',
            'nama_mahasiswa_1' => 'SALSABILA ANDHIKA NURAINI',
            "nim_1" => '2041160052'
        ]);
        $doc7 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 WEARABLE SENSOR MENGGUNAKAN FUZZY SUGENO DALAM PEMANTAUAN KESEHATAN DAN KEAMANAN LANSIA PENDERITA DEMENSIA ALZHEIMER BERBASIS APLIKASI ANDROID',
            'nama_mahasiswa_1' => 'QURROTUL AINIS SHOLEHAH',
            "nim_1" => '2041160163'
        ]);
        $doc8 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN APLIKASI MOBILE DRIVETEST LORAWAN BERBASIS ANDROID UNTUK NETWORK PLANNING DALAM JARINGAN INTERNET OF THINGS (IOT) DI PT. TELKOM INDONESIA',
            'nama_mahasiswa_1' => 'RYAN ARIEF SATRIO',
            "nim_1" => '2041160104'
        ]);
        $doc9 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN TANAMAN HOLTIKULTURA MENGGUNAKAN METODE FORWARD CHAININGS BERBASIS IoT (Studi Kasus Kelompok Tani, TANI MULYO',
            'nama_mahasiswa_1' => 'FABELA ANDRIYAN TIWI',
            "nim_1" => '2041160016'
        ]);
        $doc10 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGAMANAN TRANSMISI DATA PADA WIRELESS SENSOR NETWORK (WSN) MENGGUNAKAN ALGORITMA SHA-256',
            'nama_mahasiswa_1' => 'KRISNA MURTI RACHMADANI',
            "nim_1" => '2041160031'
        ]);

        // Dokumen 11 - 20
        $doc11 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Rancang Bangun Aplikasi Penjualan Produk Mahasiswa (ETU Market) Menggunakan Fitur Tawar Harga (Studi Kasus  ETU Polinema)',
            'nama_mahasiswa_1' => 'Ilham Okta Alpriansyah',
            "nim_1" => '2041160055'
        ]);
        $doc12 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI PANEL SURYA SEBAGAI ALTERNATIF DAYA LISTRIK YANG DIGUNAKAN DALAM SISTEM MONITORING SUHU FREEZER BOX BERBASIS WIFI (STUDI KASUS NN FROZEN FOOD WAJAK)',
            'nama_mahasiswa_1' => 'AKARIN FEBRI ABSARI',
            "nim_1" => '2041160088'
        ]);
        $doc13 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTATION OF AN IOT-BASED ENERGY CONSUMPTION MONITORING AND CONTROL SYSTEM FOR AIR CONDITIONERS IN BOARDING HOUSES',
            'nama_mahasiswa_1' => 'GADING AULIA',
            "nim_1" => '2041160028'
        ]);
        $doc14 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI PENENTUAN GAYA HIDUP PADA PENDERITA OBESITAS MENGGUNAKAN METODE RANDOM FOREST BERBASIS INTERNET OF THINGS',
            'nama_mahasiswa_1' => 'MODESTA BERLIANSA TERMATU ARSANTA',
            "nim_1" => '2041160029'
        ]);
        $doc15 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PERANCANGAN SISTEM ALAT KEAMANAN DAN PEMANTAUAN HELM ANTI MALING DENGAN FITUR AUTOMATED OBJECT TRACKING BERBASIS APLIKASI ANDROID',
            'nama_mahasiswa_1' => 'RAFLI DEWANTORO ',
            "nim_1" => '2041160075'
        ]);
        $doc16 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI CLOUD COMPUTING STUDI KOMPARATIF KINERJA OWNCLOUD DAN NEXTCLOUD PADA INFRASTRUKTUR VIRTUAL BERBASIS PROXMOX VE',
            'nama_mahasiswa_1' => 'MUHAMMAD DHORUL AULIA RIZKY',
            "nim_1" => '2041160127'
        ]);
        $doc17 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM PENDETEKSI FERTILISASI DAN PENETASAN TELUR OTOMATIS MENGGUNAKAN METODE FUZZY SUGENO BERBASIS IOT DI CV. AYAM KAMPUNG PANCAMURTI MALANG',
            'nama_mahasiswa_1' => 'Trio Prawiro Negoro',
            "nim_1" => '2041160024'
        ]);
        $doc18 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM DETEKSI PELANGGARAN LALU LINTAS PENUMPANG MOTOR LEBIH DARI 1 ORANG DAN PENGENALAN PLAT NOMOR OTOMATIS DENGAN ALGORITMA CNN',
            'nama_mahasiswa_1' => 'NAVALLINO MOCHAMMAD ALVIDO',
            "nim_1" => '2041160065'
        ]);
        $doc19 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM PERANGKAT PENDINGINAN DAN PENYIMPANANBAKPIA PATHOK BERBASIS TEKNOLOGI IOT',
            'nama_mahasiswa_1' => 'TIARA AJENG PAMUNGKAS',
            "nim_1" => '20411600110'
        ]);
        $doc20 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN MONITORING DAN CONTROLING CLAYPOT COMPOST LIMBAH RUMAH TANGGA MENGGUNAKAN METODE LOGIKA FUZZY',
            'nama_mahasiswa_1' => '',
            "nim_1" => ''
        ]);

        // Dokumen 21-30
        $doc21 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI AERIAL MAPPING UNTUK MENDETEKSI PENYAKIT BULAI PADA TANAMAN JAGUNG MENGGUNAKAN QUADCOPTER BERBASIS ALGORITMA DEEP LEARNING',
            'nama_mahasiswa_1' => 'Muhamad Fadli Kurniawan',
            "nim_1" => '2041160017'
        ]);
        $doc22 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN ALAT SORTIR BIBIT IKAN LELE DENGAN PERHITUNGAN JUMLAH DANHARGA JUAL',
            'nama_mahasiswa_1' => 'ARFIN ARDIANSYAH',
            "nim_1" => '1741160101'
        ]);
        $doc23 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Sistem Penyiraman Otomatis Berbasis Metode Fuzzy Mamdani menggunakan Teknologi LoRa pada Tanaman Anggrek Studi Kasus  DD Orchid Nursery Kota Batu',
            'nama_mahasiswa_1' => 'YOGA WISESA',
            "nim_1" => '2041160045'
        ]);
        $doc24 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI LORA PADA SISTEM KEAMAAN RUMAH CLUSTER ONE GATEWAY',
            'nama_mahasiswa_1' => 'AANG FAIRUZ ISFAHANI ROZIQ',
            "nim_1" => '2041160132'
        ]);
        $doc25 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM MONITORING GAS METANA, SUHU, DAN KELEMBAPAN UNTUK MANAJEMEN SAMPAH DI TPS TEGALGONDO DENGAN PEMANFAATAN IOT DAN MACHINE LEARNING',
            'nama_mahasiswa_1' => 'Nurulaini Putri Rahmadhani ',
            "nim_1" => '2131130058'
        ]);
        $doc26 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM DETEKSI HIPOTERMIA BAGI PENDAKI GUNUNG MENGGUNAKAN METODE FUZZY BERBASIS WIRELESS SENSOR NETWORK',
            'nama_mahasiswa_1' => 'RICHARDO DAVA SATRIA',
            "nim_1" => '2041160106'
        ]);
        $doc27 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 DETEKSI PELANGGARAN LALU LINTAS BAGI PENGENDARA TANPA HELM DAN PENGENALAN PLAT NOMOR KENDARAAN RODA DUA MENGGUNAKAN ALGORITMA CNN',
            'nama_mahasiswa_1' => 'Rizky Maulana',
            "nim_1" => '2041160097'
        ]);
        $doc28 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM KEAMANAN BERKENDARA DAN PENGAMAN HELM DENGAN MENGGUNAKAN BUZZER DAN PELACAKAN GPS MELALUI APLIKASI ANDROID',
            'nama_mahasiswa_1' => '',
            "nim_1" => ''
        ]);
        $doc29 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM MONITORING DAN PEMBERIAN OBAT OTOMATIS PADA KOLAM PETERNAK IKAN CUPANG (Studi Kasus Sumde Betta)',
            'nama_mahasiswa_1' => 'NASRUL DEVA PRATAMA',
            "nim_1" => '2041160059'
        ]);
        $doc30 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 DESIGN DAN IMPLEMENTASI SMART ELECTRIC COOLER PADA UMKM MAMSKYFOOD UNTUK PRODUKSI BUMBU PASTA',
            'nama_mahasiswa_1' => 'NADIA ALIFIANNISA HERMAWAN',
            "nim_1" => '2041160131'
        ]);
        
        // Dokumen 31-40
        $doc31 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Aplikasi Teledermatologi Untuk Klasifikasi Lesi Kulit Berdasarkan Citra Dermoskopi Berbasis Android',
            'nama_mahasiswa_1' => 'Faris Abdurrahman Gymnastiar ',
            "nim_1" => '1841160101'
        ]);
        $doc32 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM KEAMANAN SISWA TK BERBASIS IOT DENGAN TEKNOLOGI RFID',
            'nama_mahasiswa_1' => 'FEBIOLA KIREYNA SUEKKO',
            "nim_1" => '1741160068'
        ]);
        $doc33 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IDENTIFIKASI DAN KLASIFIKASI JENIS SAMPAH MENGGUNAKAN SENSOR PROXIMITY PADA TEMPAT SAMPAH PINTAR BERBASIS ANDROID',
            'nama_mahasiswa_1' => 'M HAMIM ZARKASYI',
            "nim_1" => '2041160105'
        ]);
        $doc34 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGEMBANGAN ALAT DEMONSTRASI MENGGUNAKAN RASPBERRY PI DAN PICO-W DENGAN FRAMEWORK FLASK UNTUK PENUNJANG SERTIKOM SKEMA IOT PADA BBPPMPV BOE MALANG',
            'nama_mahasiswa_1' => 'Ilham Athaariq Gistanda',
            "nim_1" => '2041160113'
        ]);
        $doc35 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IOT-BASED LINE FOLLOWER LIDAR UNTUK MENDETEKSI FOREIGN OBJECT DEBRIS (FOD) PADA RUNWAY GUNA MENINGKATKAN KESELAMATAN PENERBANGAN',
            'nama_mahasiswa_1' => 'RIFAN TRI WAHYUDI',
            "nim_1" => '2041160025'
        ]);
        $doc36 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Perancangan Antena Microstrip Circular Dan Disc sector Menggunakan Metode Multilayer Parasitic Untuk Peningkatan Gain Pada Frekuensi 2.4 GHz',
            'nama_mahasiswa_1' => 'EUODIA SIHOMBING',
            "nim_1" => '2041160015'
        ]);
        $doc37 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM DETEKSI KUALITAS UDARA AMBIEN DIDUKUNG TANAMAN SANSEVIERIA BERBASIS INTERNET OF THINGS STUDI KASUS PUSKESMAS MANDURO',
            'nama_mahasiswa_1' => 'SINTA WINDA PURNAMASARI',
            "nim_1" => '2041160071'
        ]);
        $doc38 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM KLASIFIKASI PENYAKIT DAUN ANGGREK DENDROBIUM MENGGUNAKAN METODE CONVOLUTIONAL NEURAL NETWORK (STUDI KASUS  DD ORCHID NURSERY BATU)',
            'nama_mahasiswa_1' => 'ERNA NURVITA',
            "nim_1" => '2041160058'
        ]);
        $doc39 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Utilization of the Internet of Things (IoT) in Monitoring Indoor Air Pollution Emissions from Carbon Dioxide (CO2), Particulate Matter (PM), and Volatile Organic Compounds (VOC)',
            'nama_mahasiswa_1' => 'MAZAYA HASNA INDALAH',
            "nim_1" => '2041160086'
        ]);
        $doc40 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Seleksi Cluster Head dengan Protokol LEACH-C (Centralized Low Energy Adaptive Clustering Hierarchy) untuk Efisiensi Konsumsi Energi pada WSN secara Real Time',
            'nama_mahasiswa_1' => 'Elvira Fauziah ',
            "nim_1" => '2041160116'
        ]);

        // Dokumen 41 - 50
        $doc41 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Rancang Bangun Aplikasi Pengendali Kualitas Air Akuarium Karantina Ikan Koi Menggunakan Metode Forward Chaining di Lelang Koi Nusantara Kabupaten Kediri',
            'nama_mahasiswa_1' => 'Abirawa Agung Laksana ',
            "nim_1" => '2041160039'
        ]);
        $doc42 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM PEMINJAMAN E-BIKE OTOMATIS BERBASIS IOT',
            'nama_mahasiswa_1' => 'HAFIDZ EKO PRASETYO',
            "nim_1" => '2041160007'
        ]);
        $doc43 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS PERBANDINGAN TERHADAP PENGEMBANGAN STRATEGI KEAMANAN DAN SKALABEL DENGAN MEMANFAATKAN GOOGLE CLOUD ARMOR, CLOUDFLARE, DAN KUBERNETES UNTUK APLIKASI BERBASIS KONTAINER',
            'nama_mahasiswa_1' => 'MUHAMMAD HIBBAN SYAKIR',
            "nim_1" => '2041160103'
        ]);
        $doc44 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM DATA AGREGASI UNTUK MEMPERKECIL OVER HEAD KOMUNIKASI PADA WSN',
            'nama_mahasiswa_1' => 'SEPTIAN LANJAR PRABOWO',
            "nim_1" => '2041160135'
        ]);
        $doc45 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGEMBANGAN PERMAINAN PAPAN CATUR OTOMATIS YANG DIKENDALIKAN DENGAN SUARA UNTUK PENYANDANG DISABILITAS FISIK',
            'nama_mahasiswa_1' => 'FERDIANSYAH FARANDI',
            "nim_1" => '2041160003'
        ]);
        $doc46 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI METODE YOLOv5 UNTUK DETEKSI OBJEK KORBAN BENCANA PADA ROBOT SAR (SEARCH AND RESCUE)',
            'nama_mahasiswa_1' => 'MUHAMMAD HAIDAR RAFI RAMADHAN',
            "nim_1" => '2041160160'
        ]);
        $doc47 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 DESAIN DAN IMPLEMENTASI ANTENA MIKROSTRIP PATCH ARRAY HEXAGONAL 4x4 UNTUK APLIKASI WIFI FREKUENSI 2,4 GHZ',
            'nama_mahasiswa_1' => 'LILLAH NUR IMANIA',
            "nim_1" => '2041160042'
        ]);
        $doc48 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Pengelolaan Air Toilet Di Taman Wisata Bedengan Malang Menggunakan Wireless Sensor Network Berbasis LoRa',
            'nama_mahasiswa_1' => 'Sendy Egiana Wika Putra',
            "nim_1" => '1941160124'
        ]);
        $doc49 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM KEAMANAN PARKIR OTOMATIS MENGGUNAKAN SMARTPHONE BERBASIS INTERNET OF THINGS',
            'nama_mahasiswa_1' => '',
            "nim_1" => ''
        ]);
        $doc50 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Protocol TEEN dengan Treshold Statis untuk Life Time WSN',
            'nama_mahasiswa_1' => 'KUSUMA DEWI PUSPITASARI',
            "nim_1" => '2041160006'
        ]);

        // Dokumen 51-60
        $doc51 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI FITUR GEOFENCING PADA APLIKASI ANDROID UNTUK SISTEM KEAMANAN KENDARAAN BERMOTOR DI POLITEKNIK NEGERI MALANG',
            'nama_mahasiswa_1' => 'SALWA NADIRAH',
            "nim_1" => '2041160083'
        ]);
        $doc52 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 APLIKASI MANAJEMEN STOK DAN PENGATUR JADWAL MINUM OBAT BERBASIS SUARA UNTUK TUNANETRA',
            'nama_mahasiswa_1' => 'FATONATUL MUBAROKAH',
            "nim_1" => '2041160073'
        ]);
        $doc53 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN KONTROL DAYA LISTRIK ESSENSIAL & NON ESSENSIAL BERBASIS FUZZY LOGIC MAMDANI DAN IOT (DI MINI MARKET MAKMUR TAJINAN)',
            'nama_mahasiswa_1' => 'FARAH ALMIRA EVELYN WIWINDA',
            "nim_1" => '2041160004'
        ]);
        $doc54 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Sistem Deteksi Aksi Pembelian Oleh Pelanggan Toko Retail Berdasarkan Gender Menggunakan Metode Deep Learning',
            'nama_mahasiswa_1' => 'FIRMANSYAH HIFSONY',
            "nim_1" => '2041160014'
        ]);
        $doc55 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 OPTIMASI JARINGAN WI-FI 5 GHZ DENGAN PEMANFATAAN KABEL LEAKY FEEDER PADA INFRASTRUKTUR GEDUNG AI POLITEKNIK NEGERI MALANG',
            'nama_mahasiswa_1' => 'VITANIA MAHARANI',
            "nim_1" => '2041160091'
        ]);
        $doc56 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Sistem Pembatasan Lokasi Menggunakan Metode Poligon Tidak Beraturan Pada Sistem Website E-Bike Berbasis IoT',
            'nama_mahasiswa_1' => 'MUHAMAD FAIZ KAMILUL HUDA',
            "nim_1" => '2041160092'
        ]);
        $doc57 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 DESIGN AND CONSTRUCTION OF IOT-BASED ACCIDENT- PRONE AREA DETECTOR USING DATA LOGGING AT DAU DISTRICT POLICE SECTOR AREA',
            'nama_mahasiswa_1' => 'ANNISA AZELIA AZZAHRA',
            "nim_1" => '2041160048'
        ]);
        $doc58 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Monitoring dan Controlling Lampu Penerangan Area Toilet Ground D di Taman Wisata Bedengan Malang Menggunakan Wireless Sensor Network',
            'nama_mahasiswa_1' => 'Achmad Faisal Firdaus',
            "nim_1" => '1941160068'
        ]);
        $doc59 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Kriptografi RSA untuk Pengamanan Data pada Sistem WSN',
            'nama_mahasiswa_1' => 'GILANG SANGSAKA INDONESIA',
            "nim_1" => '1941160093'
        ]);
        $doc60 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PEMANFAATAN CCTV SEBAGAI SISTEM KEAMANAN MENGGUNAKAN ALGORITMA YOLOV8 (STUDI KASUS TOKO BAJU DESTY COLLECTION)',
            'nama_mahasiswa_1' => 'Muhammad Rizki Mustafian',
            "nim_1" => '1941160104'
        ]);

        // Dokumen 61 - 70
        $doc61 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI KLASIFIKASI JENIS TEMBAKAU CACAH DENGAN METODE CONVOLUTIONAL NEURAL NETWORK (CNN) PADA CV. MALIKUS',
            'nama_mahasiswa_1' => 'Muhammad Pachlevy Arirul',
            "nim_1" => '2041160112'
        ]);
        $doc62 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Gelang Cerdas untuk Pemantauan Keberadaan Anak di Lingkungan Sekolah Berbasis IoT',
            'nama_mahasiswa_1' => 'Delanda Fitrida Indhah Sari',
            "nim_1" => '2041160054'
        ]);
        $doc63 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENERAPAN TEKNIK PENETRATION TEST DALAM MENGUJI KEAMANAN JARINGAN PADA APLIKASI BERBASIS KONTAINER',
            'nama_mahasiswa_1' => 'FEBRI HERMANA PUTRA',
            "nim_1" => '2041160072'
        ]);
        $doc64 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM INFORMASI KLINIK DAN FASILITAS NURSE CALL BERBASIS IoT STUDI KASUS  KLINIK RAWAT INAP MAULIDYA HUSADA KARANGPLOSO MALANG',
            'nama_mahasiswa_1' => 'RIZKI ANIS KURNIA RODHIYAH',
            "nim_1" => '2041160012'
        ]);
        $doc65 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI FUZZY SUGENO DALAM PENENTUAN STATUS GIZI DAN KONDISI KEPALA BATITA DI POSYANDU DAHLIA 3 DESA SIDOMULYO',
            'nama_mahasiswa_1' => 'NABILA LAILA NIRMALA',
            "nim_1" => '2041160040'
        ]);
        $doc66 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN PORTABLE CHARGER RENTAL SYSTEM BERBASIS INTERNET OF THINGS',
            'nama_mahasiswa_1' => 'ELANDARA FAJAR SYAHPUTERA',
            "nim_1" => '2041160018'
        ]);
        $doc67 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM INVENTARIS BERBASIS ANDROID DAN NEAR FIELD COMMUNICATION PADA INVENTARIS BARANG SMAN 8 MALANG',
            'nama_mahasiswa_1' => 'Louis Chandra Bawana',
            "nim_1" => '1941160107'
        ]);
        $doc68 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS ERROR DETECTION PADA KOMUNIKASI LORA DALAM PENERAPAN WIRELESS SENSOR NETWORK DENGAN METODE CYCLIC REDUNDANCY CHECK BERBASIS MIKROKONTROLER',
            'nama_mahasiswa_1' => 'KHOMSANES ADZIMATUNNISA',
            "nim_1" => '2041160038'
        ]);
        $doc69 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS KINERJA OFDM PADA KANAL AWGN DAN RAYLEIGH FADING BERBASIS SOFTWARE DEFINED RADIO',
            'nama_mahasiswa_1' => 'IVANA ARUM DIMARSASI',
            "nim_1" => '2041160068'
        ]);
        $doc70 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS PERBANDINGAN JARINGAN FIBER OPTIK MENGGUNAKAN PERANGKAT CONVERTER DENGAN SPLITTER DAN TANPA SPLITTER PADA GEDUNG AI POLITEKNIK NEGERI MALANG',
            'nama_mahasiswa_1' => 'TIKA MAHIRANI',
            "nim_1" => '2041160145'
        ]);

        // Dokumen 71-80
        $doc71 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SMART AQUASCAPE MENGGUNAKAN LOGIKA FUZZY BERBASIS IOT DAN WEBSITE STUDI KASUS ARDEV AQUATIC GALLERY',
            'nama_mahasiswa_1' => 'VIERIZKY FERNANDA DIANOVA',
            "nim_1" => '2041160062'
        ]);
        $doc72 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN ANTENA MIKROSTRIP CIRCULAR DAN CIRCULAR RING PATCH MENGGUNAKAN METODE MULTILAYER PARASITIC PADA FREKUENSI 2.4 GHZ',
            'nama_mahasiswa_1' => 'SHENDI SETYA PRADANA',
            "nim_1" => '2041160138'
        ]);
        $doc73 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS OPTIMASI STB UNTUK PENINGKATAN LAYANAN MULTIMEDIA PADA JARINGAN OLT DI GEDUNG LABORATORIUM TEKNIK TELEKOMUNIKASI',
            'nama_mahasiswa_1' => 'SANIA NURIL FIJRINA',
            "nim_1" => '2041160147'
        ]);
        $doc74 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SMART WATER RECORD AND BILLING TAGIHAN AIR KAMAR KOST',
            'nama_mahasiswa_1' => 'Rizki Viga Wulandari',
            "nim_1" => '2041160050'
        ]);
        $doc75 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 INTEGRATION SYSTEM OF VIBRANT TONE- BASED COMMUNICATION AID WITH ANDROID SPEECH TO TEXT APPLICATION FOR THE DEAF (Case Study SLB-B YPTB MALANG)',
            'nama_mahasiswa_1' => 'Hilyatus Savina Qotrunnada',
            "nim_1" => '2041160044'
        ]);
        $doc76 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI MODUL LORA SX1276 PADA RASPBERRY PI DAN PICO BERBASIS INTERNET OF THINGS SEBAGAI MEDIA EDUKASI DI BBPPMPV BOE MALANG',
            'nama_mahasiswa_1' => 'Alvin Aldorino Setiawan',
            "nim_1" => '2041160158'
        ]);
        $doc77 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PERANCANGAN DAN IMPLEMENTASI ANTENA MIKROSTRIP ARRAY PATCH DIAMOND 4X2 DENGAN I-SLOT UNTUK FREKUENSI 2,4 GHZ',
            'nama_mahasiswa_1' => 'ADE DWI ARYA',
            "nim_1" => '2041160002'
        ]);
        $doc78 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGIRIMAN DATA ANTAR NODE WSN WIRELESS SENSOR NETWORK MENGGUNAKAN SISTEM KEAMANAN HASH FUNCTION SHA-3',
            'nama_mahasiswa_1' => 'ANISYA KIRANA HARTONO',
            "nim_1" => '2041160125'
        ]);
        $doc79 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM PENERJEMAH BAHASA JERMAN SECARA REAL TIME BERBASIS INTERNET OF THINGS MENGGUNAKAN EKSTRAKSI FITUR MFCC DAN CNN',
            'nama_mahasiswa_1' => 'BERLIANA BASTIAR',
            "nim_1" => '2041160032'
        ]);
        $doc80 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PERANCANGAN SANITASI KANDANG SAPIDENGAN PLATFORM INTERNET OF THINGS MENGGUNAKAN ALGORITMA YOLOv8',
            'nama_mahasiswa_1' => 'BITA KUSUMA WARDANA',
            "nim_1" => '2041160082'
        ]);


        // Dokumen 81 - 90
        $doc81 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM DETEKSI KADAR EMISI GAS BUANG KENDARAAN BERMOTOR BERBASIS APLIKASI',
            'nama_mahasiswa_1' => 'NAUFAL ABDIR ROZAQ',
            "nim_1" => '2041160129'
        ]);
        $doc82 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI PEER TO PEER NETWORKING PADA HEADSET UNTUK STREAMING AUDIO BERBASIS INTERNET OF THINGS',
            'nama_mahasiswa_1' => 'ANITA MARSELIA',
            "nim_1" => '2041160030'
        ]);
        $doc83 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PEMANFAATAN JARINGAN SERAT OPTIK DALAM MENDUKUNG INFRASTRUKTUR VOIP STUDI KASUS IMPLEMENTASI DI POLITEKNIK NEGERI MALANG',
            'nama_mahasiswa_1' => 'ANDHINI LIONITA PRASETYA',
            "nim_1" => '2041160094'
        ]);
        $doc84 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 Implementasi Inkubator Reptil Berbasis Android Menggunakan Metode Deep Learning Dengan Model YOLO Sebagai Pendeteksi Telur Menetas',
            'nama_mahasiswa_1' => 'AHMAD ROZAK SETIA NUGRAHA',
            "nim_1" => '2041160152'
        ]);
        $doc85 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM MONITORING POLUTAN PADA TEMPAT PEMROSESAN AKHIR (TPA) BERBASIS INTERNET OF THINGS',
            'nama_mahasiswa_1' => 'ANDHIKA PUTRA AGUNG',
            "nim_1" => '2041160109'
        ]);
        $doc86 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM MONITORING SECARA REAL-TIME PADA SKUTER LISTRIK BERBASIS ANDROID MENGGUNAKAN METODE GEOFENCING',
            'nama_mahasiswa_1' => 'BELINDA CINDY ANGGREANI',
            "nim_1" => '2041160036'
        ]);
        $doc87 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM INFORMASI DAN MONITORING PERAWATAN NEW BORN BABY PADA INKUBATOR BERBASIS IOT',
            'nama_mahasiswa_1' => 'Eka Wijaya',
            "nim_1" => '2041160107'
        ]);
        $doc88 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM DETEKSI DINI DIABETES MENGGUNAKAN TEKNIK NON INVASIVE BERBASIS IOT',
            'nama_mahasiswa_1' => 'Bayu Mahastra Satria',
            "nim_1" => '2041160064'
        ]);
        $doc89 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM MONITORING DOMBA',
            'nama_mahasiswa_1' => 'ELSA ARISKA RAHMADHANI',
            "nim_1" => '2041160096'
        ]);
        $doc90 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI IOT PADA SISTEM MANAJEMEN SEWA LAHAN PARKIR DI MASJID ASSA’ADAH TANGERANG',
            'nama_mahasiswa_1' => 'Amartya Wiraswasti',
            "nim_1" => '2041160022'
        ]);

        // Dokumen 91-100
        $doc91 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM KANOPI OTOMATIS BERBASIS IOT PADA CV. LASBESI',
            'nama_mahasiswa_1' => "AFIFAH KHOIRUN NISA’",
            "nim_1" => '2041160076'
        ]);
        $doc92 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM PENCATATAN KEHADIRAN BERBASIS FACE RECOGNITION DAN KARTU RFID',
            'nama_mahasiswa_1' => '',
            "nim_1" => ''
        ]);
        $doc93 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 SISTEM PREDIKSI KEBUTUHAN BANDWIDTH DENGAN MACHINE LEARNING METODE LONG SHORT TERM MEMORY (LSTM)',
            'nama_mahasiswa_1' => 'ANANTA WICAKSANA',
            "nim_1" => '2041160049'
        ]);
        $doc94 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SMART SECURITY DAN FIRE ALERT SYSTEM PADA MUSEUM (STUDI KASUS MUSEUM SINGHASARI)',
            'nama_mahasiswa_1' => 'Edward Joel Maruli Simbolon',
            "nim_1" => '2041160061'
        ]);
        $doc95 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM KERANJANG PINTAR UNTUK MEMPERMUDAH KERJA KASIR DI SWALAYAN MENGGUNAKAN SENSOR SCAN BARCODE DAN RFID BERBASIS IOT',
            'nama_mahasiswa_1' => 'Daffa Ahmad Saechu',
            "nim_1" => '2041160047'
        ]);
        $doc96 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI GOOGLE VISION AI SEBAGAI MEDIA PEMBELAJARAN PENGENALAN OBJEK BENTUK PADA ANAK USIA DINI DI SEKOLAH TK MUSLIMAT NU RANULOGONG',
            'nama_mahasiswa_1' => 'Andrianing Tias',
            "nim_1" => '2041160084'
        ]);
        $doc97 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 IMPLEMENTASI SISTEM PEMANTAUAN DAN PEMBAYARAN LISTRIK BERBASIS TOKEN MENGGUNAKAN APLIKASI MOBILE PADA KAMAR KOST',
            'nama_mahasiswa_1' => 'Atsani Dimas Huseini',
            "nim_1" => '2041160051'
        ]);
        $doc98 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PENGEMBANGAN SISTEM PEMANTAUAN GIZI BALITA UNTUK PENCEGAHAN STUNTING',
            'nama_mahasiswa_1' => 'ARHISYA PUTRI DAMAYANTI',
            "nim_1" => '2041160063'
        ]);
        $doc99 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SMART SISTEM KEAMANAN',
            'nama_mahasiswa_1' => '',
            "nim_1" => ''
        ]);
        $doc100 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN CAMERA TRAP DENGAN PEMANTAUAN KAPASITAS DAYA BATERAI MENGGUNAKAN KOMUNIKASI MODUL LORA SX1278 DI JAVAN LANGUR CENTER',
            'nama_mahasiswa_1' => 'ALFIAN MALIK KUSWARA',
            "nim_1" => '2041160069'
        ]);

        
        // Dokumen 101-104
        $doc101 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 ANALISIS PERBANDINGAN RSTP DAN MSTP UNTUK MEMULIHKAN JARINGAN PADA LAYANAN METRONET DI JARINGAN GPON GEDUNG AH',
            'nama_mahasiswa_1' => 'DHIAS DEWA ANANTA',
            "nim_1" => '2041160149'
        ]);
        $doc102 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 DESIGN OF A Wi-Fi BASED MONITORING AND CONTROL SYSTEM FOR MILKFISH POND WATER QUALITY',
            'nama_mahasiswa_1' => 'AYU ANDIRA FITRIYANI',
            "nim_1" => '2041160037'
        ]);
        $doc103 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 RANCANG BANGUN SISTEM PERSEWAAN SEPEDA UNTUK LAYANAN UMUM DI KOTA MALANG BERBASIS ANDROID',
            'nama_mahasiswa_1' => 'DIVIA CAHAYA SALSA DIVA',
            "nim_1" => '2041160034'
        ]);
        $doc104 = DokumenPembandingPlagiasi::create([
            'filename' => 'BAB 1 PERANCANGAN DAN IMPLEMENTASI DISC SECTOR SLOT PADA ANTENA MIKROSTRIP ARRAY 4X2 DENGAN METODE TRUNCATED CORNER UNTUK FREKUENSI 2,4 GHZ',
            'nama_mahasiswa_1' => 'ADITYA VERDIANDA YAQUB',
            "nim_1" => '2041160013'
        ]);
    }
}
