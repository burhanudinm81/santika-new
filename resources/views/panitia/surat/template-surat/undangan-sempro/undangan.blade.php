<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Undangan Seminar Proposal</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 16px;
            /* isi = 12pt Word */
            margin: 10px 40px 20px 40px;
            /* atas kanan bawah kiri */
            color: black;
            position: relative;
        }

        .header {
            text-align: center;
            line-height: 1.1;
            /* lebih rapat */
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
            /* isi lebih resmi */
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

        .info-table {
            margin: 15px 0;
            font-size: 16px;
            /* isi 12pt Word */
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
    <div class="header">
        <div class="logo-container">
            <div class="logo-container">
                <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang">
            </div>
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
        <table class="info-table">
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $data['nomor_surat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{{ $data['total_lampiran'] ?? 0 }} lembar</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>Undangan Seminar Proposal Skripsi Tahap {{ $data['tahap'] ?? '-' }} Tahun Akademik
                    {{ $data['tahun_akademik'] ?? '2024/2025' }}
                </td>
            </tr>
        </table>

        <p>Kepada Yth.</p>
        <p style="margin-top: -5px;">Bapak/Ibu Dosen (terlampir sesuai jadwal)</p>
        <p style="margin-top: -5px;">Di Tempat</p>

        <p style="margin-top: 20px;">Dengan Hormat,</p>
        <p style="margin-top: -5px; text-align: justify;">Sehubungan dengan tindak lanjut dari proses Skripsi Program
            Studi D4 Jaringan
            Telekomunikasi Digital, bersama surat
            ini kami memohon kehadiran Bapak/Ibu dosen pada acara Seminar Proposal Skripsi Tahap
            {{ $data['tahap'] ?? 'I' }} yang akan
            dilaksanakan pada:
        </p>

        <table class="info-table">
            <tr>
                <td>Hari/Tanggal</td>
                <td>:</td>
                <td>{{ $data['hari_tanggal'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td>{{ $data['waktu_pelaksanaan'] ?? '08.00' }} s/d Selesai WIB</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>{{ !is_null($data['tempat']) && $data['tempat'] != '' ? $data['tempat'] : 'Ruang Kelas Gedung AH Lantai 1' }}
                </td>
            </tr>
            <tr>
                <td>Acara</td>
                <td>:</td>
                <td>Seminar Proposal Skripsi TA {{ $data['tahun_akademik'] ?? '2024/2025' }}</td>
            </tr>
            <tr>
                <td>Daftar Proposal</td>
                <td>:</td>
                <td>Terlampir</td>
            </tr>
        </table>

        <p>Berkas laporan sudah kami letakkan di atas meja Bapak/Ibu.</p>

        <p style="margin-top: 5px;">Demikian undangan ini kami sampaikan, atas kehadiran dan perhatian Bapak/Ibu kami
            ucapkan terima kasih.</p>
        <br>
        <br>
        <div class="signature-section">
            <div class="signature-box">
                <p style="margin-top: -5px;">Ketua Jurusan Teknik Elektro</p>
                <div class="signature-space">
                    <p><strong>{{ $data['nama_penandatangan'] ?? 'Dr. Eng. Ir. Ahmad Basuki, M.T.' }}</strong></p>
                    <p style="margin-top: -5px;">NIP. {{ $data['nip_penandatangan'] ?? '197012345678901234' }}</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>