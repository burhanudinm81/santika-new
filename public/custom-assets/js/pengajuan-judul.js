$(document).ready(function () {


    const $inputMahasiswa2 = $('#custom-select-mahasiswa2');
    const $dropdownMahasiswa2 = $('#dropdown-mahasiswa2');
    function fetchMahasiswa2(query = '') {
        $.ajax({
            url: '/mahasiswa/ajax/search-mahasiswa',
            data: { q: query },
            success: function (data) {
                $dropdownMahasiswa2.empty();
                if (data.length > 0) {
                    data.forEach(function (item) {
                        $dropdownMahasiswa2.append(`
                            <li class="list-group-item list-group-item-action"
                                data-id="${item.id}"
                                data-nim="${item.nim}"
                            >${item.nama}</li>
                        `);
                    });
                } else {
                    $dropdownMahasiswa2.append(`
                        <li class="list-group-item pointer-cursor text-muted disabled">
                            Tidak ada mahasiswa
                        </li>
                    `);
                }
                $dropdownMahasiswa2.removeClass('d-none');
            },
            error: function () {
                $dropdownMahasiswa2.empty().append(`
                    <li class="list-group-item text-danger disabled">
                    Gagal mengambil data
                    </li>
                `).removeClass('d-none');
            }
        })
    }
    // Ketika input fokus: tampilkan semua (query kosong)
    $inputMahasiswa2.on('focus', function () {
        fetchMahasiswa2();
    });
    // Saat mengetik
    $inputMahasiswa2.on('input', function () {
        const q = $(this).val();
        fetchMahasiswa2(q);
    });
    // Klik pada hasil dropdown
    $dropdownMahasiswa2.on('click', 'li', function () {
        const nama = $(this).text();
        const id = $(this).data('id');
        const nim = $(this).data('nim');

        $inputMahasiswa2.val(nama);
        $('#mahasiswa_2_id').val(parseInt(id));
        $('#nim-mahasiswa-2').val(nim);
        $dropdownMahasiswa2.addClass('d-none');
    });
    // Klik luar: sembunyikan dropdown
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.position-relative').length) {
            $dropdownMahasiswa2.addClass('d-none');
        }
    });


    const $inputCalonDosen = $('#custom-select-calonDosen');
    const $dropdownCalonDosen = $('#dropdown-calonDosen');
    function fetchCalonDosen(query = '') {
        $.ajax({
            url: '/mahasiswa/ajax/search-calonDosen',
            data: { q: query },
            success: function (data) {
                $dropdownCalonDosen.empty();
                if (data.length > 0) {
                    data.forEach(function (item) {
                        $dropdownCalonDosen.append(`
                            <li class="list-group-item list-group-item-action"
                                data-id="${item.id}"
                            >${item.nama}</li>
                        `);
                    });
                } else {
                    $dropdownCalonDosen.append(`
                        <li class="list-group-item pointer-cursor text-muted disabled">
                            Tidak ada dosen
                        </li>
                    `);
                }
                $dropdownCalonDosen.removeClass('d-none');
            },
            error: function () {
                $dropdownCalonDosen.empty().append(`
                    <li class="list-group-item text-danger disabled">
                    Gagal mengambil data
                    </li>
                `).removeClass('d-none');
            }
        })
    }
    // Ketika input fokus: tampilkan semua (query kosong)
    $inputCalonDosen.on('focus', function () {
        fetchCalonDosen();
    });
    // Saat mengetik
    $inputCalonDosen.on('input', function () {
        const q = $(this).val();
        fetchCalonDosen(q);
    });
    // Klik pada hasil dropdown
    $dropdownCalonDosen.on('click', 'li', function () {
        const nama = $(this).text();
        const id = $(this).data('id');

        $inputCalonDosen.val(nama);
        $('#calon_dosen_id').val(id);
        $dropdownCalonDosen.addClass('d-none');
    });
    // Klik luar: sembunyikan dropdown
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.position-relative').length) {
            $dropdownCalonDosen.addClass('d-none');
        }
    });

});
