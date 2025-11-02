<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Dosen Pembimbing Mahasiswa</title>
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
        }

        .logo-container {
            position: absolute;
            left: 60px;
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
            margin-top: 10px;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px 8px;
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
            font-size: 10pt;
            margin-top: 2mm;
        }

        th {
            font-size: 10pt;
        }

        th,
        td {
            padding: 6px;
        }

        .table-header {
            margin-bottom: 2mm;
            margin-top: 0;
            padding-left: 40px;
        }

        .repeated-header {
            display: block !important;
        }

        .page-footer {
            position: fixed;
            bottom: 20px;
            left: 10mm;
            font-size: 10px;
            color: black;
            z-index: 1000;
        }

        .highlighted-dosen {
            background-color: #cb9815ff !important;
            color: black !important;
        }

        .dosen-info {
            margin-bottom: 10px;
            font-size: 12pt;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>

<body>
    @foreach ($daftarProposal->chunk($rowsPerPage) as $pageIndex => $chunk)
        <div class="page">
            <!-- Header selalu muncul di setiap halaman -->
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

            <div class="content">
                @if ($pageIndex === 0)
                    <div class="table-header">
                        <h4 class="center-text">DAFTAR DOSEN PEMBIMBING MAHASISWA JARINGAN TELEKOMUNIKASI DIGITAL TAHUN
                            {{ $tahunAkademik }}</h4>
                        <div class="dosen-info"><strong>Nama Dosen : {{ $namaDosen }}</strong></div>
                    </div>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th style="width: 4%;">No</th>
                            <th style="width: 18%;">Nama Mahasiswa</th>
                            <th style="width: 46%;">Judul</th>
                            <th style="width: 16%;">Pembimbing 1</th>
                            <th style="width: 16%;">Pembimbing 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($chunk->count() > 0)
                            @foreach ($chunk as $index => $item)
                                <tr>
                                    <td rowspan="2" class="center-text">{{ $pageIndex * $rowsPerPage + $loop->iteration }}</td>
                                    <td>{{$item->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}</td>
                                    <td rowspan="2">{{ $item->judul ?? 'N/A' }}</td>
                                    <td rowspan="2"
                                        class="center-text {{ ($item->dosenPembimbing1->nama ?? '') == $namaDosen ? 'highlighted-dosen' : '' }}">
                                        {{ $item->dosenPembimbing1->nama ?? 'N/A' }}
                                    </td>
                                    <td rowspan="2"
                                        class="center-text {{ ($item->dosenPembimbing2->nama ?? '') == $namaDosen ? 'highlighted-dosen' : '' }}">
                                        {{ $item->dosenPembimbing2->nama ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{$item->proposalMahasiswas[1]->mahasiswa->nama ?? "-" }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="no-data">
                                    Tidak ada data mahasiswa yang dibimbing oleh {{ $namaDosen }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    @endforeach

</body>


</html>