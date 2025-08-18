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
            <label for="penguasaanMateri1">Penguasaan Materi:</label>
            <input type="number" class="form-control" id="penguasaanMateri1" 
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_penguasaan_materi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_penguasaan_materi2 ?? '' }}"
                @endif  name="penguasaanMateri1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="presentasi1">Presentasi:</label>
            <input type="number" class="form-control" id="presentasi1"  
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_presentasi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_presentasi2 ?? '' }}"
                @endif 
                name="presentasi1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="karyaTulis">Karya Tulis:</label>
            <input type="number" class="form-control" id="karyaTulis1"  
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_karya_tulis1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_karya_tulis2 ?? '' }}"
                @endif 
                name="karyaTulis1" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata1">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata_penguji1" name="rata_rata_penguji1" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" id="countAveragePenguji1">Kalkulasi</button>

        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Penguji 1:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji1 ?? '' }}"
                readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Penguji 2:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji2 ?? '' }}"
                readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem1 ?? '' }}"
                readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem2 ?? '' }}"
                readonly>
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
            <label for="penguasaanMateri2">Penguasaan Materi:</label>
            <input type="number" class="form-control" id="penguasaanMateri2"
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_penguasaan_materi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_penguasaan_materi2 ?? '' }}"
                @endif  
             name="penguasaanMateri2" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="presentasi2">Presentasi:</label>
            <input type="number" class="form-control" id="presentasi2" 
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_presentasi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_presentasi2 ?? '' }}"
                @endif 
            name="presentasi2" min="0"
                max="100">
        </div>
        <div class="form-group">
            <label for="hasil_karya2">Karya Tulis:</label>
            <input type="number" class="form-control" id="karyaTulis2" name="karyaTulis2" min="0"
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_karya_tulis1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa2->nilai_karya_tulis2 ?? '' }}"
                @endif 
                max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata2">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata_penguji2" name="rata_rata_penguji2" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" id="countAveragePenguji2">Kalkulasi</button>
        <div class="form-group">
            <label for="nilai_pembimbing2_2">Nilai Penguii 1:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji1 ?? '' }}"
                readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_2">Nilai Penguii 2:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji2 ?? '' }}"
                readonly>
        </div>
         <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem1 ?? '' }}"
                readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem2 ?? '' }}"
                readonly>
        </div>
    </div>
@elseif($mainProposal->prodi_id == 2)
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
            <label for="penguasaanMateri1">Penguasaan Materi:</label>
            <input type="number" class="form-control" id="penguasaanMateri1" name="penguasaanMateri1"
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_penguasaan_materi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_penguasaan_materi2 ?? '' }}"
                @endif
                min="0" max="100">
        </div>
        <div class="form-group">
            <label for="presentasi1">Presentasi:</label>
            <input type="number" class="form-control" id="presentasi1" name="presentasi1" min="0"
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_presentasi1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_presentasi2 ?? '' }}"
                @endif
                max="100">
        </div>
        <div class="form-group">
            <label for="karyaTulis">Karya Tulis:</label>
            <input type="number" class="form-control" id="karyaTulis1" name="karyaTulis" min="0"
                @if($roleDosen == 'Dosen Penguji Sidang TA 1') 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_karya_tulis1 ?? '' }}" 
                @else 
                    value="{{ $nilaiAkhirMahasiswa1->nilai_karya_tulis2 ?? '' }}"
                @endif
                max="100">
        </div>
        <div class="form-group">
            <label for="rata_rata1">Rata-Rata:</label>
            <input type="text" class="form-control" id="rata_rata_penguji1" name="rata_rata_penguji1" readonly>
        </div>
        <button type="button" class="btn btn-outline-danger" id="countAveragePenguji1">Kalkulasi</button>

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
         <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 1:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem1 ?? '' }}" readonly>
        </div>
        <div class="form-group">
            <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
            <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem2 ?? '' }}" readonly>
        </div>
    </div>
@endif
