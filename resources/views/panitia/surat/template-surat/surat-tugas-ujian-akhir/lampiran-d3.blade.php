<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lampiran Jadwal Ujian Akhir</title>
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
            margin-bottom: 15px;
            margin-top: -15px
        }

        .logo-container {
            position: absolute;
            left: 60px;
            top: 70%;
            transform: translateY(-50%);
            width: 150px;
            height: 150px;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .header-text {
            margin-left: 100px;
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

        .nilai-container {
            border-left: 1px solid black;
        }

        .nilai-header {
            text-align: center;
            background-color: #cccccc !important;
            font-weight: bold;
        }

        .nilai-angka,
        .nilai-huruf {
            text-align: center;
            width: 50%;
            display: inline-block;
        }

        .letter-footer {
            margin-top: 30px;
            padding: 0 60px;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
            margin-right: 30px;
        }

        .signature-content {
            display: inline-block;
            text-align: left;
        }

        .signature-content p {
            margin: 5px 0;
        }

        .signature-name {
            padding-top: 50px;
        }

        @page {
            margin: 10mm 15mm;
            size: A4 landscape;
        }

        body {
            font-size: 10pt;
        }

        .header {
            padding: 5mm 15mm;
            height: 35mm;
        }

        .header h3,
        .header h4,
        .header p {
            font-size: 11pt;
            margin: 1px 0;
        }

        .logo-container {
            left: 15mm;
            width: 100px;
        }

        .header-text {
            margin-left: 70px;
        }

        .content {
            padding: 4mm 5mm 5mm 5mm;
            margin-top: 0;
        }

        .letter-footer {
            padding: 0 5mm;
            margin-top: 20px;
        }

        .signature-section {
            margin-top: 30px;
            margin-right: 15mm;
        }

        .page-number {
            bottom: 20px;
            right: 15mm;
            font-size: 9pt;
            color: #666;
            display: block;
        }

        table {
            font-size: 9pt;
            margin-top: 2mm;
        }

        th {
            font-size: 9pt;
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
    @foreach ($jadwalSemhas->chunk($rowsPerPage) as $pageIndex => $chunk)
        <div class="page">
            @if ($pageIndex === 0)
                <div class="header">
                    <div class="logo-container">
                        <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang">
                    </div>
                    <div class="header-text">
                        <h3 style="font-size:21px;">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
            <h3 style="font-size:21px;">DAN TEKNOLOGI</h3>
            <h3 style="font-size:19px;">POLITEKNIK NEGERI MALANG</h3>
            <h4 style="font-size:19px; bold-text">JURUSAN TEKNIK ELEKTRO</h4>
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
            @endif

            <div class="content">
                @if ($pageIndex === 0)
                    <div class="table-header">
                        <h4><strong>LAMPIRAN SURAT TUGAS</strong></h4>
                    </div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:center; width: 5%;">No</th>
                            <th style="text-align:center; width: 15%;">Mahasiswa</th>
                            <th style="text-align:center; width: 30%;">Judul</th>
                            <th style="text-align:center; width: 25%;">Dosen Pembimbing</th>
                            <th style="text-align:center; width: 25%;">Dosen Penguji</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;">(1)</th>
                            <th style="text-align:center;">(2)</th>
                            <th style="text-align:center;">(3)</th>
                            <th style="text-align:center;">(4)</th>
                            <th style="text-align:center;">(5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chunk as $index => $item)
                            <tr>
                                <td rowspan="2" class="center-text">{{ $pageIndex * $rowsPerPage + $loop->iteration }}</td>
                                <td>
                                    {{ $item->proposal->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}<br>
                                    {{ $item->proposal->proposalMahasiswas[0]->mahasiswa->nim ?? "-"  }}
                                </td>
                                <td rowspan="2" class="left-text" style="font-size: 10pt;">{{ $item->proposal->judul ?? "-" }}</td>
                                <td rowspan="2" class="left-text" style="font-size: 10pt;">
                                    Utama: 
                                    <br>{{ $item->proposal->dosenPembimbing1->nama ?? "-" }}<br>
                                    Pendamping: 
                                    <br>{{ $item->proposal->dosenPembimbing2->nama ?? "-" }}
                                </td>
                                <td rowspan="2" class="left-text" style="font-size: 10pt;">
                                    Ketua: 
                                    <br>{{ $item->proposal->dosenPengujiSidangTA1->nama ?? "-" }}<br>
                                    Anggota: 
                                    <br>{{ $item->proposal->dosenPengujiSidangTA2->nama ?? "-" }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $item->proposal->proposalMahasiswas[1]->mahasiswa->nama ?? "-" }}<br>
                                    {{ $item->proposal->proposalMahasiswas[1]->mahasiswa->nim ?? "-"  }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($loop->last)
                    <div class="letter-footer">
                        <div class="signature-section">
                            <div class="signature-content">
                                <p style="margin: 5px 0;">Malang, {{ $formData['tanggal_tanda_tangan'] ?? '' }}</p>
                                <p style="margin: 5px 0 40px 0; margin-top: -6px;">Direktur,</p>
                                <div class="signature-name">
                                    <p style="margin: 5px 0;"><strong>{{ $formData['nama_penandatangan'] ?? '' }}</strong>
                                    </p>
                                    <p style="margin: 5px 0; margin-top: -6px;">NIP. {{ $formData['nip_penandatangan'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="page-number"></div>
        </div>
    @endforeach

</body>

</html>