@if ($mainProposal->prodi_id == 1)
    {{-- mahasiswa 1 --}}
    <div class="col-md-6 student-panel">
        {{-- input hidden mahasiswa 1 --}}
        <input type="hidden" name="mahasiswa1_id" value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->id }}">

        <div class="form-group">
            <label for="nama_mahasiswa1">Nama Mahasiswa 1:</label>
            <input type="text" class="form-control" id="nama_mahasiswa1" name="nama_mahasiswa1"
                value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->nama }}" readonly>
        </div>
        <div class="form-group">
            <label for="sikap1">Sikap:</label>
            <input type="number" class="form-control" id="sikap1" name="sikap1" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="kemampuan1">Kemampuan:</label>
            <input type="number" class="form-control" id="kemampuan1" name="kemampuan1" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="hasil_karya1">Hasil Karya:</label>
            <input type="number" class="form-control" id="hasil_karya1" name="hasil_karya1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="laporan1">Laporan:</label>
            <input type="number" class="form-control" id="laporan1" name="laporan1" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata1">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata1" name="rata_rata1" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" id="countAverage1">Kalkulasi</button>
        <div class="form-group">
            <label for="nilai_pembimbing1_1">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing1"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem1 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem2 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Penguji 1:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji1 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Penguji 2:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji2 ?? '' }}" readonly>
        </div>
    </div>

    {{-- mahasiswa 2 --}}
    <div class="col-md-6 student-panel">
        {{-- input hidden mahasiswa 2 --}}
        <input type="hidden" name="mahasiswa2_id" value="{{ $mainProposal->proposalMahasiswas[1]->mahasiswa->id }}">

        <div class="form-group">
            <label for="nama_mahasiswa2">Nama Mahasiswa 2:</label>
            <input type="text" class="form-control" id="nama_mahasiswa2" name="nama_mahasiswa2"
                value="{{ $mainProposal->proposalMahasiswas[1]->mahasiswa->nama }}" readonly>
        </div>
        <div class="form-group">
            <label for="sikap2">Sikap:</label>
            <input type="number" class="form-control" id="sikap2" name="sikap2" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="kemampuan2">Kemampuan:</label>
            <input type="number" class="form-control" id="kemampuan2" name="kemampuan2" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="hasil_karya2">Hasil Karya:</label>
            <input type="number" class="form-control" id="hasil_karya2" name="hasil_karya2" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="laporan2">Laporan:</label>
            <input type="number" class="form-control" id="laporan2" name="laporan2" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata2">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata2" name="rata_rata2" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" id="countAverage2">Kalkulasi</button>
        <div class="form-group">
            <label for="nilai_pembimbing1_2">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa2_pembimbing1"
                value="{{ $nilaiAkhirMahasiswa2->avg_nilai_dospem1 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_2">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa2_pembimbing1"
                value="{{ $nilaiAkhirMahasiswa2->avg_nilai_dospem2 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_2">Nilai Penguii 1:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa2_pembimbing1"
                value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji1 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_2">Nilai Penguii 2:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa2_pembimbing1"
                value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji2 ?? '' }}" readonly>
        </div>
    </div>
@elseif($mainProposal->prodi_id == 2)
    {{-- mahasiswa  --}}
    <div class="col-md-6 student-panel">
        {{-- input hidden mahasiswa --}}
        <input type="hidden" name="mahasiswa1_id"
            value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->id }}">

        <div class="form-group">
            <label for="nama_mahasiswa1">Nama Mahasiswa:</label>
            <input type="text" class="form-control" id="nama_mahasiswa1" name="nama_mahasiswa1"
                value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->nama }}" readonly>
        </div>
        <div class="form-group">
            <label for="sikap1">Sikap:</label>
            <input type="number" class="form-control" id="sikap1" name="sikap1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="kemampuan1">Kemampuan:</label>
            <input type="number" class="form-control" id="kemampuan1" name="kemampuan1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="hasil_karya1">Hasil Karya:</label>
            <input type="number" class="form-control" id="hasil_karya1" name="hasil_karya1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="laporan1">Laporan:</label>
            <input type="number" class="form-control" id="laporan1" name="laporan1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata1">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata1" name="rata_rata1" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" data-student="1"
            onclick="hitungRataRata(this)">Kalkulasi</button>
        <div class="form-group">
            <label for="nilai_pembimbing1_1">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" id="nilai_pembimbing1_1" name="nilai_pembimbing1_1" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" id="nilai_pembimbing2_1" name="nilai_pembimbing2_1" readonly>
        </div>
    </div>
@endif
