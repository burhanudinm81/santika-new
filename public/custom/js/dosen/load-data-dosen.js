$("document").ready(function () {
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