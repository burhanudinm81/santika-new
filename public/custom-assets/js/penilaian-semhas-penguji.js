let nilaiPenguasaanMateri1 = 0;
let nilaiPresentasi1 = 0;
let nilaiKaryaTulis1 = 0;

let nilaiPenguasaanMateri2 = 0;
let nilaiPresentasi2 = 0;
let nilaiKaryaTulis2 = 0;

function hitungAverageNilaiByPenguji(nilaiPenguasaanMateri, nilaiPresentasi, nilaiKaryaTulis) {
    let total = parseFloat(nilaiPenguasaanMateri) + parseFloat(nilaiPresentasi) + parseFloat(nilaiKaryaTulis);
    let average = total / 3;
    return average;
}

// mahasiswa 1
let nilaiPenguasaanMateriMahasiswa1 = document.getElementById('penguasaanMateri1');
let nilaiPresentasiMahasiswa1 = document.getElementById('presentasi1');
let nilaiKaryaTulisMahasiswa1 = document.getElementById('karyaTulis1');
let nilaiRataRataPengujiMahasiswa1 = document.getElementById('rata_rata_penguji1');
let buttonHitungAvgPenguji1 = document.getElementById('countAveragePenguji1');

nilaiPenguasaanMateriMahasiswa1.addEventListener('input', function () {
    nilaiPenguasaanMateri1 = nilaiPenguasaanMateriMahasiswa1.value;
    console.log(nilaiPenguasaanMateri1);
});

nilaiPresentasiMahasiswa1.addEventListener('input', function () {
    nilaiPresentasi1 = nilaiPresentasiMahasiswa1.value;
    console.log(nilaiPresentasi1);
});

nilaiKaryaTulisMahasiswa1.addEventListener('input', function () {
    nilaiKaryaTulis1 = nilaiKaryaTulisMahasiswa1.value;
    console.log(nilaiKaryaTulis1);
});

buttonHitungAvgPenguji1.addEventListener('click', function () {
    let average = hitungAverageNilaiByPenguji(nilaiPenguasaanMateri1, nilaiPresentasi1, nilaiKaryaTulis1);
    nilaiRataRataPengujiMahasiswa1.value = average.toFixed(2);
});

// mahasiswa 2
let nilaiPenguasaanMateriMahasiswa2 = document.getElementById('penguasaanMateri2');
let nilaiPresentasiMahasiswa2 = document.getElementById('presentasi2');
let nilaiKaryaTulisMahasiswa2 = document.getElementById('karyaTulis2');
let nilaiRataRataPengujiMahasiswa2 = document.getElementById('rata_rata_penguji2');
let buttonHitungAvgPenguji2 = document.getElementById('countAveragePenguji2');

nilaiPenguasaanMateriMahasiswa2.addEventListener('input', function () {
    nilaiPenguasaanMateri2 = nilaiPenguasaanMateriMahasiswa2.value;
});

nilaiPresentasiMahasiswa2.addEventListener('input', function () {
    nilaiPresentasi2 = nilaiPresentasiMahasiswa2.value;
});

nilaiKaryaTulisMahasiswa2.addEventListener('input', function () {
    nilaiKaryaTulis2 = nilaiKaryaTulisMahasiswa2.value;
});

buttonHitungAvgPenguji2.addEventListener('click', function () {
    let average = hitungAverageNilaiByPenguji(nilaiPenguasaanMateri2, nilaiPresentasi2, nilaiKaryaTulis2);
    nilaiRataRataPengujiMahasiswa2.value = average.toFixed(2);
});

