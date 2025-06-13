$(document).ready(function() {
    // Variabel untuk menyimpan timer debounce
    let debounceTimer;

    // Ambil URL untuk pencarian
    const searchUrl = $('#search-mahasiswa-form').attr("action");
    
    // Target elemen input dan tabel body
    const searchInput = $('input[name="table_search"]');
    const tableBody = $('#mahasiswa-table-body');

    // Fungsi untuk menjalankan pencarian dan memperbarui tabel
    function performSearch(query) {
        // Tampilkan loading state
        tableBody.html('<tr><td colspan="6" class="text-center">Mencari...</td></tr>');

        $.get(searchUrl, { search: query }) // Kirim query sebagai ?search=...
            .done(function(response) {
                // Kosongkan tabel sebelum mengisi dengan data baru
                tableBody.empty();

                // Parsing data JSON
                const data = JSON.parse(response.data);

                if (data && data.length > 0) {
                    // Jika data ditemukan, loop dan tampilkan
                    $.each(data, function(index, mahasiswa) {
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
                        tableBody.append(row);
                    });
                } else {
                    // Jika tidak ada data yang cocok
                    tableBody.html('<tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>');
                }
            })
            .fail(function() {
                // Jika terjadi error saat request
                tableBody.html('<tr><td colspan="6" class="text-center">Terjadi kesalahan. Gagal memuat data.</td></tr>');
            });
    }

    // Event listener untuk 'keyup' pada input pencarian
    searchInput.on('keyup', function() {
        // Hapus timer yang sedang berjalan
        clearTimeout(debounceTimer);

        const query = searchInput.val();

        // Buat timer baru
        debounceTimer = setTimeout(function() {
            performSearch(query);
        }, 500); // Tunggu 500ms (0.5 detik) setelah user berhenti mengetik
    });

    // Menangani klik pada tombol search
    $('#search-button').on('click', function(event) {
        event.preventDefault(); // Mencegah perilaku default tombol submit
        clearTimeout(debounceTimer); // Matikan timer jika ada
        const query = searchInput.val();
        performSearch(query);
    });
});