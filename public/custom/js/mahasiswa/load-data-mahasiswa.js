$("document").ready(function () {
    function loadAllMahasiswa() {
        const url = $("#tabel-mahasiswa").data("url");
        // Elemen tbody
        const tableBody = $('#mahasiswa-table-body');

        // Tampilkan loading state
        tableBody.html('<tr><td colspan="6" class="text-center">Memuat...</td></tr>');

        $.get(url)
            .done(function (response) {
                const dataMahasiswa = JSON.parse(response.data);

                // Mengkosongkan tbody
                tableBody.html("");
                
                // Iterasi (loop) pada setiap data mahasiswa
                $.each(dataMahasiswa, function (index, mahasiswa) {
                    // Buat baris tabel (tr) baru menggunakan template literal
                    const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${mahasiswa.periode.tahun}</td>
                                    <td>${mahasiswa.NIM}</td>
                                    <td>${mahasiswa.nama}</td>
                                    <td>${mahasiswa.prodi.prodi}</td> 
                                    <td>${mahasiswa.kelas}</td>
                                    <td>${mahasiswa.angkatan}</td>
                                </tr>
                    `;

                    // Sisipkan baris baru ke dalam tbody
                    tableBody.append(row);
                });
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Gagal Memuat Data");
            });
    }

    loadAllMahasiswa();
});