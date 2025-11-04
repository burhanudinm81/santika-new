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
                                    <td class="d-flex justify-content-center align-items-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Aksi</button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-hapus-data d-block w-100" data-id="${mahasiswa.id}" data-nama="${mahasiswa.nama}">Hapus</a>
                                                <a class="btn btn-ganti-password d-block w-100" data-id="${mahasiswa.id}" data-nama="${mahasiswa.nama}">Ganti Password</a>
                                            </div>
                                        </div>
                                    </td>
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

    const formImporFile = $("#impor-file");

    // Elemen overlay spinner
    const $loadingOverlay = $('#loading-overlay');

    // Event submit form impor file
    formImporFile.submit(function (event) {
        event.preventDefault();

        let data = new FormData($(this)[0]);

        // TAMPILKAN SPINNER SEBELUM REQUEST
        $loadingOverlay.css('display', 'flex').hide().fadeIn(200);

        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: response => {
                const message = response.message;

                // Sembunyikan Spinner
                $loadingOverlay.fadeOut(200);

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(message);
                $("#modal-popup-sukses").modal();

                // Memuat ulang data Mahasiswa
                loadAllMahasiswa();
            },
            error: (jqXHR, status, error) => {
                const errorMessage = jqXHR.responseJSON.message;

                // Sembunyikan Spinner
                $loadingOverlay.fadeOut(200);

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();

                console.log(jqXHR.responseJSON.errors);
            }
        });
    });
});