<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Ujian Seminar Proposal</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            color: black;
        }

        .header {
            text-align: center;
            line-height: 1.2;
            padding: 20px 60px;
            background-color: white;
            position: relative;
            height: 140px;
            margin-bottom:5px;
        }

        .logo-container {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            width: 120px;
            height: auto;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .header-text {
            margin-left: 120px;
        }

        h3,
        h4,
        p {
            margin: 2px 0;
            font-size: 12pt;
            font-weight: normal;
        }

        .bold-text {
            font-weight: bold;
            font-size: 14pt;
        }

        hr {
            border: 1.5px solid black;
            margin: 15px 0;
        }

        a {
            color: blue;
            text-decoration: underline;
        }

        .content {
            padding: 20px 60px 20px 60px;
            margin-top: 0;
        }

        .page {
            page-break-after: always;
            position: relative;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        .page-number {
            position: absolute;
            bottom: 20px;
            right: 60px;
            font-size: 9pt;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
            text-align: left;
        }

        th {
            text-align: center;
            background-color: #cccccc !important;
            font-weight: bold;
            font-size: 10pt;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .table-header {
            margin-bottom: 5px;
            margin-top: 0;
        }

        .center-text {
            text-align: center;
        }

        .letter-footer {
            margin-top: 30px;
            padding: 0 60px;
        }

        @page {
            margin: 10mm 15mm;
            size: A4 portrait;
        }

        body {
            font-size: 10pt;
        }

        .header {
            padding: 5mm 15mm;
            height: 35mm;
        }

        .header h3 {
    font-size: 14pt;
}
.header h4,
.header p {
    font-size: 12pt;
    margin: 1px 0;
}

        .logo-container {
            left: 15mm;
            width: 100px;
        }

        .header-text {
            margin-left: 90px;
        }

        .content {
            padding: 4mm 5mm 5mm 5mm;
            margin-top: 0;
        }

        .letter-footer {
            padding: 0 5mm;
            margin-top: 20px;
        }

        .page-number {
            bottom: 20px;
            right: 15mm;
            font-size: 9pt;
            color: #666;
            display: block;
        }

        table {
            font-size: 10pt;
            margin-top: 2mm;
        }

        th {
            font-size: 10pt;
        }

        th,
        td {
            padding: 4px;
        }

        .table-header {
            margin-bottom: 2mm;
            margin-top: 0;
            padding-left: 40px;
        }

        .repeated-header {
            display: block !important;
        }
    </style>
</head>

<body>
    @foreach ($jadwalSempro->chunk($rowsPerPage) as $pageIndex => $chunk)
        <div class="page">
            @if ($pageIndex === 0)
                <div class="header">
                    <div class="logo-container">
                        <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang">
                    </div>
                    <div class="header-text">
                        <h3>KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
                        <h3>DAN TEKNOLOGI</h3>
                        <h3 style="font-size:12pt">POLITEKNIK NEGERI MALANG</h3>
                        <h4 class="bold-text">JURUSAN TEKNIK ELEKTRO</h4>
                        <p>Jalan Soekarno Hatta Nomor 9 Jatimulyo, Lowokwaru, Malang 65141</p>
                        <p>Telepon (0341) 404424, 404425, Faksimile (0341) 404420</p>
                        <p>Laman <a href="http://www.polinema.ac.id">www.polinema.ac.id</a></p>
                    </div>
                    <hr />
                </div>
            @else
                <div class="header repeated-header">
                    <div class="logo-container">
                        <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang">
                    </div>
                    <div class="header-text">
                        <h3>KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
                        <h3>DAN TEKNOLOGI</h3>
                        <h3 style="font-size:12pt">POLITEKNIK NEGERI MALANG</h3>
                        <h4 class="bold-text">JURUSAN TEKNIK ELEKTRO</h4>
                        <p>Jalan Soekarno Hatta Nomor 9 Jatimulyo, Lowokwaru, Malang 65141</p>
                        <p>Telepon (0341) 404424, 404425, Faksimile (0341) 404420</p>
                        <p>Laman <a href="http://www.polinema.ac.id">www.polinema.ac.id</a></p>
                    </div>
                    <hr />
                </div>
            @endif

            <div class="content">
                @if ($pageIndex === 0)
                    <div class="table-header center-text">
                        <strong>HASIL UJIAN SEMINAR PROPOSAL<br>D4 JARINGAN TELEKOMUNIKASI DIGITAL MAHASISWA TAHAP {{ $tahap->tahap }}
                            {{ $periodeAktif->tahun }}</strong>
                    </div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 60%;">Judul Proposal</th>
                            <th style="width: 15%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($chunk->count() > 0)
                            @foreach ($chunk as $index => $item)
                                <tr>
                                    <td class="center-text">{{ $pageIndex * $rowsPerPage + $loop->iteration }}</td>
                                    <td>{{ $item->proposal->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}</td>
                                    <td>{{ $item->proposal->judul ?? "-" }}</td>
                                    <td class="center-text">{{ $item->status ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="center-text">Tidak ada data tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($loop->last)
                    <div>
                        <p style="margin-top: 20px;"><strong>Keterangan :</strong></p>
                        <ul style="list-style-type: disc; font-weight: bold; padding-left: 20px;">
                            <li style="font-weight: normal; margin-bottom: 10px;">
                                Hasil proposal yang diterima dengan revisi harap melakukan revisi paling lambat 2 minggu
                                setelah ujian dan mengumpulkan form tanda tangan revisi kepada panitia. Jika tidak
                                mengumpulkan form tanda tangan revisi maka dianggap tidak menuntaskan dan akan
                                dilaksanakan
                                ujian ulang di tahap berikutnya.
                            </li>
                            <li style="font-weight: normal; margin-bottom: 10px;">
                                Mahasiswa akan mendapatkan Pembimbing 1 dan Pembimbing 2 ketika dinyatakan selesai
                                revisi.
                            </li>
                            <li style="font-weight: normal; margin-bottom: 10px;">
                                Mahasiswa yang dinyatakan ditolak wajib untuk melakukan revisi paling lambat 2 minggu
                                pada
                                penguji 1 dan 2 jika menggunakan judul yang sama dan bisa mendaftar ujian ulang dengan
                                meng-upload form tanda tangan revisi kepada panitia.
                            </li>
                            <li style="font-weight: normal; margin-bottom: 10px;">
                                Mahasiswa yang dinyatakan ditolak boleh untuk mengajukan judul yang baru dengan
                                ketentuan
                                mencari dosen konsultasi baru yang sesuai dengan topik judul yang diajukan.
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
            <div class="page-number"></div>
        </div>
    @endforeach

</body>

</html>