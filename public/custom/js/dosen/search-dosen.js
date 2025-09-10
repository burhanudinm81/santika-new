$(document).ready(function () {
    // Variabel untuk menyimpan timer debounce
    let debounceTimer;

    // Ambil URL untuk pencarian
    const searchUrl = $('#search-dosen-form').attr("action");

    // Target elemen input dan tabel body
    const searchInput = $('input[name="table_search"]');
    const tableBody = $('#dosen-table-body');

    // Fungsi untuk menjalankan pencarian dan memperbarui tabel
    function performSearch(query) {
        // Tampilkan loading state
        tableBody.html('<tr><td colspan="5" class="text-center">Mencari...</td></tr>');

        $.get(searchUrl, { search: query }) // Kirim query sebagai ?search=...
            .done(function (response) {
                // Kosongkan tabel sebelum mengisi dengan data baru
                tableBody.empty();

                // Parsing data JSON
                const data = JSON.parse(response.data);

                if (data && data.length > 0) {
                    // Jika data ditemukan, loop dan tampilkan
                    $.each(data, function (index, dosen) {
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
                        tableBody.append(row);
                    });
                } else {
                    // Jika tidak ada data yang cocok
                    tableBody.html('<tr><td colspan="4" class="text-center">Data tidak ditemukan.</td></tr>');
                }
            })
            .fail(function () {
                // Jika terjadi error saat request
                tableBody.html('<tr><td colspan="4" class="text-center">Terjadi kesalahan. Gagal memuat data.</td></tr>');
            });
    }

    // Event listener untuk 'keyup' pada input pencarian
    searchInput.on('keyup', function () {
        // Hapus timer yang sedang berjalan
        clearTimeout(debounceTimer);

        const query = searchInput.val();

        // Buat timer baru
        debounceTimer = setTimeout(function () {
            performSearch(query);
        }, 500); // Tunggu 500ms (0.5 detik) setelah user berhenti mengetik
    });

    // Menangani klik pada tombol search
    $('#search-button').on('click', function (event) {
        event.preventDefault(); // Mencegah perilaku default tombol submit
        clearTimeout(debounceTimer); // Matikan timer jika ada
        const query = searchInput.val();
        performSearch(query);
    });
});