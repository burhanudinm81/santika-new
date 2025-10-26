$(document).ready(function() {
    // Handler untuk jumlah ruang
    $('#jumlah-ruang').on('input change', function() {
        var jumlah = parseInt($(this).val()) || 1;
        var html = '';
        for (var i = 0; i < jumlah; i++) {
            html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td><input type="text" class="form-control" id="ruang" name="ruang[]" required></td>' +
                '</tr>';
        }
        $('#ruang-table-body').html(html);
    });

    // Handler untuk jumlah tanggal
    $('#jumlah-tanggal').on('input change', function() {
        var jumlah = parseInt($(this).val()) || 1;
        var html = '';
        for (var i = 0; i < jumlah; i++) {
            html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td><input type="date" class="form-control" id="tanggal" name="tanggal[]" required></td>' +
                '</tr>';
        }
        $('#tanggal-table-body').html(html);
    });

    // Handler untuk jumlah sesi
    $('#jumlah-sesi').on('input change', function() {
        var jumlah = parseInt($(this).val()) || 1;
        var html = '';
        for (var i = 0; i < jumlah; i++) {
            html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td><input type="time" class="form-control" id="waktu_mulai" name="sesi['+i+'][waktu_mulai]" required></td>' +
                '<td><input type="time" class="form-control" id="waktu_selesai" name="sesi['+i+'][waktu_selesai]" required></td>' +
                '</tr>';
        }
        $('#sesi-table-body').html(html);
    });

    // Tampilkan/sembunyikan tabel waktu berhalangan dosen sesuai checkbox
    function toggleWaktuBerhalangan() {
        if ($('#waktu-berhalangan-dosen').is(':checked')) {
            $('#input-waktu-berhalangan').show();
            $('#info-waktu-berhalangan').show();
            $('#tambah-waktu-berhalangan').show();
        } else {
            $('#input-waktu-berhalangan').hide();
            $('#info-waktu-berhalangan').hide();
            $('#tambah-waktu-berhalangan').hide();
        }
    }
    // Inisialisasi saat load
    toggleWaktuBerhalangan();
    // Event handler saat checkbox berubah
    $('#waktu-berhalangan-dosen').on('change', toggleWaktuBerhalangan);

    // Tambah baris waktu berhalangan dosen
    $(document).on('click', '#tambah-waktu-berhalangan', function() {
        var tbody = $('#waktu-berhalangan-table-body');
        var idx = tbody.find('tr').length;
        var dosenOptions = '';
        if (window.dosenOptionsHtml) {
            dosenOptions = window.dosenOptionsHtml;
        } else {
            // Ambil dari baris pertama
            dosenOptions = tbody.find('select').first().html();
            window.dosenOptionsHtml = dosenOptions;
        }
        var html = '<tr>' +
            '<td>' + (idx + 1) + '</td>' +
            '<td><select class="custom-select" name="waktu_berhalangan['+idx+'][dosen_id]">' + dosenOptions + '</select></td>' +
            '<td><input type="date" class="form-control" name="waktu_berhalangan['+idx+'][tanggal]" value="2024-01-01" required></td>' +
            '<td><input type="time" class="form-control" name="waktu_berhalangan['+idx+'][waktu_mulai]" value="00:00" required></td>' +
            '<td><input type="time" class="form-control" name="waktu_berhalangan['+idx+'][waktu_selesai]" value="01:00" required></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm remove-sesi">Hapus</button></td>' +
            '</tr>';
        tbody.append(html);
    });

    // Hapus baris waktu berhalangan dosen
    $(document).on('click', '.remove-sesi', function() {
        $(this).closest('tr').remove();
        // Update nomor urut
        $('#waktu-berhalangan-table-body tr').each(function(i, tr) {
            $(tr).find('td:first').text(i+1);
        });
    });

    // Tambah Ruang jika tombol "Tambah Ruang" diklik
    $(document).on('click', '#tambah-ruang', function() {
        var tbody = $('#ruang-table-body');
        var idx = tbody.find('tr').length;
        var html = '<tr>' +
            '<td>' + (idx + 1) + '</td>' +
            '<td><input type="text" class="form-control" name="ruang[]" required></td>' +
            '<td class="td-100-wrapper"><button type="button" class="btn btn-danger remove-ruang">Hapus</button></td>' +
            '</tr>';
        tbody.append(html);
    });

    // Hapus Ruang jika tombol "Hapus" pada baris ruang diklik
    $(document).on('click', '.remove-ruang', function() {
        $(this).closest('tr').remove();
        // Update nomor urut
        $('#ruang-table-body tr').each(function(i, tr) {
            $(tr).find('td:first').text(i+1);
        });
    });

    // Tambah Tanggal jika tombol "Tambah Tanggal" diklik
    $(document).on('click', '#tambah-tanggal', function() {
        var tbody = $('#tanggal-table-body');
        var idx = tbody.find('tr').length;
        var html = '<tr>' +
            '<td>' + (idx + 1) + '</td>' +
            '<td><input type="date" class="form-control" name="tanggal[]" required></td>' +
            '<td class="td-100-wrapper"><button type="button" class="btn btn-danger remove-tanggal">Hapus</button></td>' +
            '</tr>';
        tbody.append(html);
    });

    // Hapus Tanggal jika tombol "Hapus" pada baris tanggal diklik
    $(document).on('click', '.remove-tanggal', function() {
        $(this).closest('tr').remove();
        // Update nomor urut
        $('#tanggal-table-body tr').each(function(i, tr) {
            $(tr).find('td:first').text(i+1);
        });
    });
});
