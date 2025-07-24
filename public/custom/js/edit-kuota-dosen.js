$(document).ready(function() {
    let debounceTimer;

    // Fungsi untuk mengambil data dan merender tabel
    function fetchData(prodiId, searchQuery, tableBodyId) {
        const tableBody = $(`#${tableBodyId}`);
        tableBody.html('<tr><td colspan="4" class="text-center">Memuat data...</td></tr>');

        $.get('/panitia/kuota-dosen', { prodi_id: prodiId, search: searchQuery })
            .done(function(data) {
                tableBody.empty();
                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        const row = `
                            <tr>
                                <td class="text-center align-middle">${index + 1}</td>
                                <td class="align-middle">${item.nama}</td>
                                <td class="text-center align-middle">${item.kuota}</td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-sm btn-info edit-btn"
                                            data-id="${item.id}"
                                            data-nama="${item.nama}"
                                            data-kuota="${item.kuota}"
                                            data-prodi="${prodiId}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });
                } else {
                    tableBody.html('<tr><td colspan="4" class="text-center">Data tidak ditemukan.</td></tr>');
                }
            })
            .fail(function() {
                tableBody.html('<tr><td colspan="4" class="text-center">Gagal memuat data.</td></tr>');
            });
    }

    // Panggil data saat halaman pertama kali dimuat
    fetchData(1, '', 'kuota-d3-tbody'); // D3 (prodi_id 1)
    fetchData(2, '', 'kuota-d4-tbody'); // D4 (prodi_id 2)

    // Handler untuk search D3
    $('#search-dosen-d3').on('keyup', function() {
        clearTimeout(debounceTimer);
        const query = $(this).val();
        debounceTimer = setTimeout(function() {
            fetchData(1, query, 'kuota-d3-tbody');
        }, 500);
    });

    // Handler untuk search D4
    $('#search-dosen-d4').on('keyup', function() {
        clearTimeout(debounceTimer);
        const query = $(this).val();
        debounceTimer = setTimeout(function() {
            fetchData(2, query, 'kuota-d4-tbody');
        }, 500);
    });

    // EVENT DELEGATION untuk tombol edit
    // Kita pasang listener di tabel, tapi hanya bereaksi jika tombol .edit-btn diklik
    $('#tabel-kuota-dosen-d3, #tabel-kuota-dosen-d4').on('click', '.edit-btn', function() {
        const button = $(this);
        const id = button.data('id');
        const nama = button.data('nama');
        const kuota = button.data('kuota');
        const prodiId = button.data('prodi');

        // Isi form di dalam modal
        $('#edit-kuota-id').val(id);
        $('#edit-prodi-id').val(prodiId);
        $('#edit-nama-dosen').text(nama);
        $('#edit-kuota-value').val(kuota);

        // Tampilkan modal
        $('#editKuotaModal').modal('show');
    });

    // Handler untuk submit form edit di modal
    $('#editKuotaForm').on('submit', function(event) {
        event.preventDefault();
        
        const id = $('#edit-kuota-id').val();
        const prodiId = $('#edit-prodi-id').val();
        const kuotaValue = $('#edit-kuota-value').val();
        
        // Tentukan nama field berdasarkan prodiId
        const data = {};
        if (prodiId == 1) {
            data.kuota_d3 = kuotaValue;
        } else {
            data.kuota_d4 = kuotaValue;
        }

        $.ajax({
            url: `/panitia/kuota-dosen/${id}`,
            method: 'PUT',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editKuotaModal').modal('hide');

                    // Menampilkan pop up sukses
                    $("#modal-popup-sukses .modal-body").text(response.message);
                    $("#modal-popup-sukses").modal();

                    // Muat ulang data tabel yang sesuai
                    if (prodiId == 1) {
                        fetchData(1, $('#search-dosen-d3').val(), 'kuota-d3-tbody');
                    } else {
                        fetchData(2, $('#search-dosen-d4').val(), 'kuota-d4-tbody');
                    }
                }
            },
            error: function(jqXHR, status, error) {
                $('#editKuotaModal').modal('hide');
                const errorMessage = jqXHR.responseJSON.message;

                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();
            }
        });
    });

    $('#reset-kuota-d3').on('click', function(){
        const resetKuotaModal = $('#modal-reset-kuota');

        const prodiInput = resetKuotaModal.find('input[name="prodi_id"]');
        prodiInput.val(1);

        resetKuotaModal.modal('show');
    });

    $('#reset-kuota-d4').on('click', function(){
        const resetKuotaModal = $('#modal-reset-kuota');

        const prodiInput = resetKuotaModal.find('input[name="prodi_id"]');
        prodiInput.val(2);

        resetKuotaModal.modal('show');
    });
});