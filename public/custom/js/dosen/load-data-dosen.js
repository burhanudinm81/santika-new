$("document").ready(function () {
    const url = $("#tabel-dosen").data("url");
    // Elemen tbody
    const tableBody = $('#dosen-table-body');

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
});