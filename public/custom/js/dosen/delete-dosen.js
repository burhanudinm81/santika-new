$("document").ready(function () {
    const modalHapusDosen = $("#modal-hapus-dosen");
    const tableBody = $('#dosen-table-body');
    const formHapusDosen = $("#form-hapus-dosen");
    const tabelDosen = $("#tabel-dosen");

    tableBody.on('click', '.btn-hapus-data', function () {
        const dosenId = $(this).data("id");
        const namaDosen = $(this).data("nama");
        modalHapusDosen.find("input[name='dosen_id']").val(dosenId);
        modalHapusDosen.find(".modal-body").text(`Apakah Anda yakin ingin menghapus ${namaDosen}?`);
        modalHapusDosen.modal("show");
    });

    formHapusDosen.submit(function (event) {
        // Mencegah form submit secara default
        event.preventDefault();

        modalHapusDosen.modal("hide");

        const url = formHapusDosen.attr("action");
        const method = "delete";
        const formData = formHapusDosen.serialize();

        $.ajax({
            url: url,
            method: method,
            data: formData,
            dataType: "json",
            success: function (response) {
                const message = response.message;

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(message);
                $("#modal-popup-sukses").modal();
            },
            error: function (jqXHR, status, error) {
                const errorMessage = jqXHR.responseJSON.message;

                // Reset isi modal error
                $("#modal-popup-error .modal-body").text("");

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();
            },
            complete: function () {
                // Jika Modal/Pop Up Sukses atau Pop Up Error ditutup kembalikan ke halaman Daftar Panitia TA
                $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                    muatUlangTabelDosen();
                });
            }
        });
    });

    function muatUlangTabelDosen() {
        const url = tabelDosen.data("url");

        // Tampilkan loading state
        tableBody.html('<tr><td colspan="5" class="text-center">Memuat...</td></tr>');

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
                                    <td class="text-center">${index + 1}</td>
                                    <td class="text-center">${dosen.NIDN}</td>
                                    <td class="text-center">${dosen.NIP}</td>
                                    <td class="text-center">${dosen.nama}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Aksi</button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-hapus-dosen d-block w-100" data-id="${dosen.id}" data-nama="${dosen.nama}">Hapus</a>
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
});
