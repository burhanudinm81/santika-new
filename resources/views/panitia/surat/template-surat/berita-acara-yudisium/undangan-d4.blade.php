<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Berita Acara Yudisium</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 16px; /* isi = 12pt Word */
            margin: 20px 80px 20px 80px; /* atas kanan bawah kiri */
            color: black;
            position: relative;
        }

        .header {
            text-align: center;
            line-height: 1.1; /* lebih rapat */
            margin-bottom: 0px;
            background: white;
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
            font-size: 13px; /* 10pt Word */
            line-height: 1.1;
        }

        .bold-text {
            font-weight: bold;
            font-size: 19px;
        }

        hr {
            border: 1.2px solid black;
            margin: 10px 0;
        }

        a {
            color: blue;
            text-decoration: underline;
        }

        /* Class content untuk halaman 1 */
        .content-page1 {
            line-height: 1.3; /* isi lebih resmi */
            margin-top: -10px;
            font-size: 16px; /* 12pt Word */
        }

        .content-page1 p {
            margin: 5px 0;
            line-height: 1.3;
            text-align: justify;
        }

        .content-page1 ol,
        .content-page1 ul {
            line-height: 1.3;
            margin: 10px 0;
        }

        .content-page1 li {
            margin: 5px 0;
            line-height: 1.3;
        }

        /* Class content untuk halaman 2 - posisi tengah */
        .content-page2 {
            font-size: 16px; /* 12pt Word */
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: calc(100vh - 200px);
            padding: 20px 0;
        }

        .content-page2 p {
            margin: 5px 0;
            line-height: 1.3;
        }

        .content-page2 ol {
            line-height: 1.6;
            margin: 15px 0;
        }

        .content-page2 li {
            margin: 10px 0;
            line-height: 1.6;
        }

        .page {
            page-break-after: always;
            position: relative;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        .page-footer {
            position: absolute;
            bottom: 20px;
            left: 0px;
            font-size: 9pt;
            color: #666;
        }

        .info-row {
            display: flex;
            margin: 2px 0;
        }

        .info-label {
            width: 80px;
            font-weight: normal;
            flex-shrink: 0;
        }

        .info-separator {
            width: 10px;
            text-align: center;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .signature-section {
            margin-top: 40px;
            text-align: right;
            margin-right: 30px;
            line-height: 1.3;
        }

        .signature-content {
            display: inline-block;
            text-align: left;
        }

        .signature-content p {
            margin: 4px 0;
        }

        .signature-name {
            padding-top: 70px;
        }

        .center-content {
            text-align: center;
            margin: 20px 0;
        }

        .center-content p {
            margin: 5px 0;
        }

        .decision-section {
            margin: 20px 40px;
        }

        .decision-section p {
            margin: 10px 0;
        }

        .decision-section ol {
            margin: 15px 0;
            line-height: 1.6;
        }

        .decision-section li {
            margin: 10px 0;
            line-height: 1.6;
        }

        .info-table {
            margin: 15px 0;
            font-size: 16px; /* isi 12pt Word */
            border-collapse: collapse;
            line-height: 1.3;
        }

        .info-table td {
            padding: 0px 4px;
            vertical-align: top;
        }

        .info-table td:first-child {
            padding-left: 0;
            width: 100px;
        }

        .info-table td:nth-child(2) {
            width: 10px;
            text-align: center;
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

        @page {
            margin: 3mm 3mm 2mm 2mm;
            size: A4;
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

            .content-page1 {
                margin-top: 5px;
            }

            .content-page1 p,
            .content-page1 div {
                page-break-inside: avoid;
                margin: 5px 0;
            }

            .content-page2 p,
            .content-page2 div {
                page-break-inside: avoid;
                margin: 5px 0;
            }

            .info-table {
                page-break-inside: avoid;
            }

            .signature-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <div class="page">
        <div class="page-footer">FRM.RTD.01.34.03</div>
        
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

        <div class="content-page1">
            <table class="info-table">
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td><span id="nomor-display">{{ $data['nomor_surat'] ?? '' }}</span></td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td><span id="lampiran-display">{{ $data['jumlah_lampiran'] ?? 0 }}</span> lembar</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>Berita Acara Yudisium Skripsi Tahap {{ $data['tahap'] ?? '' }} TA {{ $data['tahun_akademik'] ?? '' }}</td>
                </tr>
            </table>
            <br>
            <p style="margin: 5px 0; line-height: 1.3;">Yth. Direktur Politeknik Negeri Malang</p>
            <br>
            <p style="margin: 5px 0; line-height: 1.3; text-align: justify;">Bersama ini kami kirimkan Berita Acara Yudisium Skripsi Semester {{ $data['semester'] ?? '' }} Tahun Akademik
                {{ $data['tahun_akademik'] ?? '' }} Program Studi Jaringan Telekomunikasi Digital Jurusan Teknik Elektro Politeknik Negeri Malang.</p>
            <br>
            <p style="margin: 5px 0; line-height: 1.3; text-align: justify;">Demikian atas perhatiannya kami sampaikan terima kasih.</p>
            <br>
            <br>
            <div class="signature-section">
                <div class="signature-box">
                    <p style="margin: 5px 0;">Malang, <span id="tanggal-display">{{ $data['tanggal_tanda_tangan'] ?? '' }}</span></p>
                    <p style="margin: 5px 0 40px 0; margin-top: -6px;">Ketua Jurusan</p>
                    <div class="signature-space">
                        <p style="margin: 5px 0;"><strong>{{ $data['nama_penandatangan'] ?? '' }}</strong></p>
                        <p style="margin: 5px 0;margin-top: -6px;">NIP. {{ $data['nip_penandatangan'] ?? '' }}</p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <p style="margin: 2px 0;">Tembusan Yth.:</p>
                <p style="margin: 2px 0;">1. Wakil Direktur I</p>
                <p style="margin: 2px 0;">2. Kasubag. Akademik</p>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="page-footer">FRM.RTD.01.34.03</div>
        
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
            <hr/>
        </div>

        <div class="content-page2">
            <div style="text-align: center; margin-bottom: 30px;">
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>BERITA ACARA</strong></p>
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>YUDISIUM UJIAN SKRIPSI</strong></p>
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>SEMESTER {{ strtoupper($data['semester'] ?? '') }} TAHUN AKADEMIK {{ $data['tahun_akademik'] ?? '' }}</strong></p>
                <p style="margin: 5px 0;">Program Studi Jaringan Telekomunikasi Digital Jurusan Teknik Elektro</p>
                <p style="margin: 15px 0;">Nomor: {{ $data['nomor_surat'] ?? '' }}</p>
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>KEPUTUSAN TENTANG</strong></p>
                <p style="font-size: 12pt; margin: 5px 0;">Hasil Ujian Skripsi</p>
                <p style="margin: 5px 0;">Program Studi Jaringan Telekomunikasi Digital Jurusan Teknik Elektro</p>
                <p style="margin: 5px 0;">Politeknik Negeri Malang</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>KETUA MAJELIS</strong></p>
            </div>

            <div>
                <p style="margin: 10px 0;">Mengingat :</p>
                <ol style="margin: 15px 0; line-height: 1.6;">
                    <li style="margin: 10px 0; line-height: 1.6;">Buku Pedoman Akademik Politeknik Negeri Malang</li>
                    <li style="margin: 10px 0; line-height: 1.6;">Rapat Majelis Penguji Ujian Skripsi Program Studi Jaringan Telekomunikasi Digital, Jurusan Teknik
                        Elektro, Politeknik Negeri Malang</li>
                </ol>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="font-weight: bold; font-size: 12pt; margin: 5px 0;"><strong>MEMUTUSKAN</strong></p>
            </div>

            <div>
                <p style="margin: 10px 0;">Menetapkan :</p>
                <ol style="margin: 15px 0; line-height: 1.6;">
                    <li style="margin: 10px 0; line-height: 1.6;">Hasil Ujian Skripsi Program Studi Jaringan Telekomunikasi Digital Jurusan Teknik Elektro</li>
                </ol>
            </div>
        </div>
    </div>

</body>

</html>