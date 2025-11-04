$("document").ready(function () {
    function loadAllDosen() {
        const url = $("#tabel-dosen").data("url");
        // Elemen tbody
        const tableBody = $('#dosen-table-body');

        // Tampilkan loading state
        tableBody.html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');

        $.get(url)
            .done(function (response) {
                const dataDosen = JSON.parse(response.data);

                // Mengkosongkan tbody
                tableBody.html("");

                // Iterasi (loop) pada setiap data dosen
                $.each(dataDosen, function (index, dosen) {
                    // Buat baris tabel (tr) baru menggunakan template literal
                    const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${dosen.NIDN}</td>
                                    <td>${dosen.NIP}</td>
                                    <td>${dosen.nama}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Opsi</button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-hapus-data d-block w-100" data-id="${dosen.id}" data-nama="${dosen.nama}">Hapus</a>
                                                <a class="btn btn-ganti-password d-block w-100" data-id="${dosen.id}" data-nama="${dosen.nama}">Ganti Password</a>
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

                // Memuat ulang data Dosen
                loadAllDosen();
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