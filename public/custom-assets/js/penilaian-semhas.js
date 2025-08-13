// Nilai Inisiasi

let nilaiSikap1 = 0;
let nilaiKemampuan1 = 0;
let nilaiHasilKarya1 = 0;
let nilaiLaporan1 = 0;
let nilaiRataRata1 = 0;

let nilaiSikap2 = 0;
let nilaiKemampuan2 = 0;
let nilaiHasilKarya2 = 0;
let nilaiLaporan2 = 0;
let nilaiRataRata2 = 0;

// Menghitung rata-rata nilai
function hitungAverageNilai(sikap, kemampuan, hasilKarya, laporan) {
    let total = parseFloat(sikap) + parseFloat(kemampuan) + parseFloat(hasilKarya) + parseFloat(laporan);
    let average = total / 4;

    return average;
}

// menghitung rata-rata nilai dari penguji
function hitungAverageNilaiByPenguji(penguasaanMateri, presentasi, karyaTulis) {
    let total = parseFloat(penguasaanMateri) + parseFloat(presentasi) + parseFloat(karyaTulis);
    let average = total / 3;
    return average;
}


// -> Mahasiswa 1 =======================================================
// by Dosen Pembimbing ---------------------------------------------------
let nilaiSikapMahasiswa1 = document.getElementById('sikap1');
let nilaiKemampuanMahasiswa1 = document.getElementById('kemampuan1');
let nilaiHasilKaryaMahasiswa1 = document.getElementById('hasil_karya1');
let nilaiLaporanMahasiswa1 = document.getElementById('laporan1');
let nilaiRataRataMahasiswa1 = document.getElementById('rata_rata_penguji1');
let buttonHitungAvg1 = document.getElementById('countAverage1');

nilaiSikapMahasiswa1.addEventListener('input', function () {
    nilaiSikap1 = nilaiSikapMahasiswa1.value;
});

nilaiKemampuanMahasiswa1.addEventListener('input', function () {
    nilaiKemampuan1 = nilaiKemampuanMahasiswa1.value;
});

nilaiHasilKaryaMahasiswa1.addEventListener('input', function () {
    nilaiHasilKarya1 = nilaiHasilKaryaMahasiswa1.value;
});

nilaiLaporanMahasiswa1.addEventListener('input', function () {
    nilaiLaporan1 = nilaiLaporanMahasiswa1.value;
});

buttonHitungAvg1.addEventListener('click', function () {
    let average = hitungAverageNilai(nilaiSikap1, nilaiKemampuan1, nilaiHasilKarya1, nilaiLaporan1);
    nilaiRataRataMahasiswa1.value = average.toFixed(2);
});

// by Dosen Penguji ------------------------------------------------------

// -> Mahasiswa 2 =======================================================
// by Dosen Pembimbing ---------------------------------------------------
let nilaiSikapMahasiswa2 = document.getElementById('sikap2');
let nilaiKemampuanMahasiswa2 = document.getElementById('kemampuan2');
let nilaiHasilKaryaMahasiswa2 = document.getElementById('hasil_karya2');
let nilaiLaporanMahasiswa2 = document.getElementById('laporan2');
let nilaiRataRataMahasiswa2 = document.getElementById('rata_rata_penguji2');
let buttonHitungAvg2 = document.getElementById('countAverage2');

nilaiSikapMahasiswa2.addEventListener('input', function () {
    nilaiSikap2 = nilaiSikapMahasiswa2.value;
});

nilaiKemampuanMahasiswa2.addEventListener('input', function () {
    nilaiKemampuan2 = nilaiKemampuanMahasiswa2.value;
});

nilaiHasilKaryaMahasiswa2.addEventListener('input', function () {
    nilaiHasilKarya2 = nilaiHasilKaryaMahasiswa2.value;
});

nilaiLaporanMahasiswa2.addEventListener('input', function () {
    nilaiLaporan2 = nilaiLaporanMahasiswa2.value;
});

buttonHitungAvg2.addEventListener('click', function () {
    let average = hitungAverageNilai(nilaiSikap2, nilaiKemampuan2, nilaiHasilKarya2, nilaiLaporan2);
    nilaiRataRataMahasiswa2.value = average.toFixed(2);
});

// by Dosen Penguji ------------------------------------------------------

