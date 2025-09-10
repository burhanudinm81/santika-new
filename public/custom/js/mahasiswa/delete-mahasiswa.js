$("document").ready(function () {
    const modalHapusMahasiswa = $("#modal-hapus-mahasiswa");
    const tableBody = $('#mahasiswa-table-body');
    const formHapusMahasiswa = $("#form-hapus-mahasiswa");
    const tabelMahasiswa = $("#tabel-mahasiswa");

    tableBody.on('click', '.btn-hapus-data', function () {
        const mahasiswaId = $(this).data("id");
        const namaMahasiswa = $(this).data("nama");
        modalHapusMahasiswa.find("input[name='mahasiswa_id']").val(mahasiswaId);
        modalHapusMahasiswa.find(".modal-body").text(`Apakah Anda yakin ingin menghapus ${namaMahasiswa}?`);
        modalHapusMahasiswa.modal("show");
    });

    formHapusMahasiswa.submit(function (event) {
        // Mencegah form submit secara default
        event.preventDefault();

        modalHapusMahasiswa.modal("hide");

        const url = formHapusMahasiswa.attr("action");
        const method = "delete";
        const formData = formHapusMahasiswa.serialize();

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
                    muatUlangTabelMahasiswa();
                });
            }
        });
    });

    function muatUlangTabelMahasiswa() {
        const url = tabelMahasiswa.data("url");

        // Tampilkan loading state
        tableBody.html('<tr><td colspan="8" class="text-center">Memuat...</td></tr>');

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
                                    <td class="text-center">${index + 1}</td>
                                    <td class="text-center">${mahasiswa.periode.tahun}</td>
                                    <td class="text-center">${mahasiswa.NIM}</td>
                                    <td class="text-center">${mahasiswa.nama}</td>
                                    <td class="text-center">${mahasiswa.prodi.prodi}</td> 
                                    <td class="text-center">${mahasiswa.kelas}</td>
                                    <td class="text-center">${mahasiswa.angkatan}</td>
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
});
