<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lampiran Berita Acara Yudisium</title>
    <style>
        body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    margin: 0;
    padding: 0;
    color: black;
}

/* ===== HEADER ===== */
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
    left: 15mm;
    top: 50%;
    transform: translateY(-50%);
    width: 25mm;   /* Gunakan mm untuk PDF */
    height: 25mm;
}

.logo-container img {
    width: 25mm;   /* Ukuran fixed dalam mm */
    height: 25mm;
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

/* ===== CONTENT ===== */
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

/* ===== FOOTER & SIGNATURE ===== */
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

/* ===== PAGE SETTINGS ===== */
@page {
    margin: 10mm 15mm;
    size: A4 landscape;
}

body {
    font-size: 10pt;
}
.logo-container {
    position: absolute;
    left: 15mm;
    top: 50%;
    transform: translateY(-50%);
    width: 30mm;   /* Gunakan mm untuk PDF */
    height: 30mm;
}

.logo-container img {
    width: 30mm;   /* Ukuran fixed dalam mm */
    height: 30mm;
    display: block;

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

.page-footer {
    position: fixed;
    bottom: 20px;
    left: 10mm;
    font-size: 10px;
    color: black;
    z-index: 1000;
}
    </style>
</head>

<body>

    <div class="page-footer">
        FRM.RTD.01.34.03
    </div>

    @php
        $rowsPerPage = 9;
        $totalStudents = count($data);
        $totalPages = ceil($totalStudents / $rowsPerPage);
    @endphp

    @foreach ($data->chunk($rowsPerPage) as $pageIndex => $chunk)
        <div class="page">
            @if ($pageIndex === 0)
                <div class="header">
                    <div class="logo-container">
                        <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang" class="logo-img">
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
                        <img src="https://iili.io/FOMazWQ.md.png" alt="Logo Politeknik Negeri Malang" class="logo-img">
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
                    <div class="table-header">
                        <h4>Berdasarkan hasil rapat Yudisium Ujian Skripsi <strong>{{ $formData['tanggal_pelaksanaan_yudisium'] ?? '' }}</strong> mahasiswa yang dinyatakan LULUS/TIDAK LULUS, sebagai berikut:</h4>
                    </div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 4%;">No.</th>
                            <th rowspan="2" style="width: 16%;">Nama</th>
                            <th rowspan="2" style="width: 10%;">NIM</th>
                            <th rowspan="2" style="width: 6%;">Kelas</th>
                            <th rowspan="2" style="width: 36%;">Judul Skripsi</th>
                            <th colspan="2" style="width: 16%;">Nilai Skripsi</th>
                            <th rowspan="2" style="width: 8%;">Status</th>
                        </tr>
                        <tr>
                            <th style="width: 8%;">Nilai Angka</th>
                            <th style="width: 8%;">Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chunk as $index => $student)
                            <tr>
                                <td class="center-text">{{ $pageIndex * $rowsPerPage + $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>
                                <td class="center-text">{{ $student->nim }}</td>
                                <td class="center-text">{{ $student->kelas }}</td>
                                <td>{{ $student->judulskripsi }}</td>
                                <td class="center-text">{{ $student->nilaiangka }}</td>
                                <td class="center-text">{{ $student->nilaihuruf }}</td>
                                <td class="center-text">{{ $student->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($loop->last)
                    <div class="letter-footer">
                        <p style="margin: 20px 0;">Apabila ada kekeliruan dan dianggap perlu, keputusan ini akan
                            dirubah.</p>
                        <div class="signature-section">
                            <div class="signature-content">
                                <p style="margin: 5px 0;">{{ $formData['tanggal_tanda_tangan'] ?? '' }}</p>
                                <p style="margin: 5px 0 40px 0; margin-top: -6px;">Ketua Pelaksana Skripsi</p>
                                <div class="signature-name">
                                    <p style="margin: 5px 0;"><strong>{{ $formData['nama_penandatangan'] ?? '' }}</strong></p>
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
