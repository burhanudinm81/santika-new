<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Surat Tugas Seminar Proposal</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 16px;
            /* isi = 12pt Word - sama dengan template lain */
            margin: 10px 40px 20px 40px;
            /* atas kanan bawah kiri - sama dengan template lain */
            color: black;
            position: relative;
        }

        .header {
            text-align: center;
            line-height: 1.1;
            /* lebih rapat - sama dengan template lain */
            margin-bottom: 0px;
            background: white;
            position: relative;
            /* tidak fixed, bisa discroll */
        }

        .logo-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 120px;
            height: auto;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .header-content {
            margin-left: 90px;
        }

        .header-content h3 {
            margin: 1px 0;
            font-weight: normal;
            line-height: 1.1;
        }

        .header-content h4 {
            margin: 1px 0;
            font-weight: bold;
            line-height: 1.1;
        }

        .header-content p {
            margin: 1px 0;
            font-size: 13px;
            /* 10pt Word */
            line-height: 1.1;
        }

        hr {
            border: 1.2px solid black;
            margin: 10px 0;
        }

        .content {
            line-height: 1.3;
            /* isi lebih resmi - sama dengan template lain */
            margin-top: -10px;
            font-size: 16px;
            /* 12pt Word */
        }

        .content p {
            margin: 5px 0;
            line-height: 1.3;
            text-align: justify;
        }

        .content ol,
        .content ul {
            line-height: 1.3;
            margin: 10px 0;
        }

        .content li {
            margin: 5px 0;
            line-height: 1.3;
        }

        .center-text {
            text-align: center;
        }

        .center-text p {
            text-align: center;
        }

        .content-text {
            text-align: justify;
        }

        .signature-section {
            margin-top: 40px;
            text-align: right;
            margin-right: 30px;
            line-height: 1.3;
        }

        .signature-box {
            display: inline-block;
            text-align: left;
        }

        .signature-box p {
            margin: 4px 0;
        }

        .signature-space {
            padding-top: 70px;
        }

        @media print {
            body {
                margin: 3mm 3mm 2mm 2mm;
            }

            .header {
                page-break-after: avoid;
            }

            .logo-container {
                width: 120px !important;
                height: 120px !important;
            }

            .logo-container img {
                width: 120px !important;
                height: 120px !important;
            }

            .content {
                margin-top: 5px;
            }

            .content p,
            .content div {
                page-break-inside: avoid;
                margin: 5px 0;
            }

            .signature-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang">
        </div>
        <div class="header-content">
            <h3 style="font-size:21px;">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
            <h3 style="font-size:21px;">DAN TEKNOLOGI</h3>
            <h3 style="font-size:19px;">POLITEKNIK NEGERI MALANG</h3>
            <h4 style="font-size:19px;">JURUSAN TEKNIK ELEKTRO</h4>
            <p>Jalan Soekarno Hatta Nomor 9 Jatimulyo, Lowokwaru, Malang 65141</p>
            <p>Telepon (0341) 404424, 404425, Faksimile (0341) 404420</p>
            <p>Laman <a href="http://www.polinema.ac.id">www.polinema.ac.id</a></p>
        </div>
        <hr />
    </div>

    <div class="content">
        <div class="center-text">
            <p style="margin-top: 30px; margin-bottom: 5px;"><strong><u>SURAT TUGAS</u></strong></p>
            <p style="margin-top: -5px;">NOMOR: {{ $data['nomor_surat'] ?? '' }}</p>
        </div>

        <p style="margin-top: 20px;" class="content-text">
            Direktur Politeknik Negeri Malang dengan ini memberikan tugas kepada Tenaga Pengajar Program Studi Jaringan
            Telekomunikasi Digital Jurusan Teknik Elektro pada Semester {{ $data['semester'] ?? 'Genap' }} Tahun
            Akademik {{ $data['tahun_akademik'] ?? '2024/2025' }} yang
            dilaksanakan pada tanggal {{ $data['tanggal_mulai'] ?? '' }} sampai dengan
            {{ $data['tanggal_selesai'] ?? '' }} yang namanya tercantum di dalam kolom (4) sebagai Dosen
            Penguji (Ketua/Anggota) Seminar Proposal Skripsi/Tesis. Adapun nama-nama Tenaga Pengajar tersebut terlampir
            pada surat tugas ini. Selesai melaksanakan tugas harap menyampaikan laporan tertulis kepada Direktur.
        </p>

        <p style="margin-top: 15px;" class="content-text">
            Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab.
        </p>
        <br>
        <br>
        <div class="signature-section">
            <div class="signature-box">
                <p style="margin-top: -5px;">Malang, {{ $data['tanggal_tanda_tangan'] ?? '' }}</p>
                <p style="margin-top: -5px;">Direktur,</p>
                <div class="signature-space">
                    <p><strong>{{ $data['nama_penandatangan'] ?? '' }}</strong></p>
                    <p style="margin-top: -5px;">NIP. {{ $data['nip_penandatangan'] ?? '' }}</p>
                </div>
            </div>
        </div>

        <p style="margin-top: 40px;">
            <strong>Tembusan:</strong><br>
            1. Wakil Direktur<br>
            2. Ketua Jurusan<br>
            3. Pokja Kepegawaian
        </p>
    </div>

</body>

</html>