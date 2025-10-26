$(document).ready(function () {
    $('.dosen-penguji-select').select2({
        theme: 'bootstrap4',
        width: 'resolve',
        placeholder: '-- Pilih Dosen --',
        allowClear: true,
        // dropdownParent: $('#container-tabel-edit-jadwal'),
        dropdownAutoWidth: true,
        dropdownCss: { 'max-width': 'calc(100vw - 20px)' }
    });

    // handler untuk perubahan dosen penguji 1
    $(document).on('change', '.dosen-penguji-1-select', function () {
        var $sel = $(this);

        // Mencegah loop berulang
        if ($sel.data('prevent-change')) return;

        var prevVal = $sel.data('prev-id');
        var jadwalId = $sel.data('id');
        var dosenPenguji1 = $sel.val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!jadwalId) return;

        $.ajax({
            url: '/panitia/jadwal-sidang-akhir/update-penguji-sidang-akhir-1',
            method: 'PUT',
            data: {
                jadwal_id: jadwalId,
                dosen_penguji_1_id: dosenPenguji1
            },
            headers: {
                'X-CSRF-TOKEN': token
            },
            beforeSend: function () {
                $sel.prop('disabled', true);
            },
            success: function (response) {
                // opsional: notif sukses sederhana
                console.log('Update penguji 1 sukses');
                $sel.data('prev-id', dosenPenguji1);

                console.log(response);

                if (response.message) {
                    $("#pop-up-success strong").text("");
                    $("#pop-up-success strong").text(response.message);
                    $("#pop-up-success").fadeIn(300);

                    setTimeout(() => { $("#pop-up-success").fadeOut(300); }, 3000);
                }
                else {
                    $("#pop-up-success strong").text("");
                    $("#pop-up-success strong").text("Berhasil mengubah Dosen Penguji Seminar Proposal 1");
                    $("#pop-up-success").fadeIn(300);

                    setTimeout(() => { $("#pop-up-success").fadeOut(300); }, 3000);
                }
            },
            error: function (xhr) {
                console.error('Gagal update penguji 1');

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    // alert(xhr.responseJSON.message);
                    $("#pop-up-error ul").text("");
                    $("#pop-up-error ul").text(xhr.responseJSON.message)
                    $("#pop-up-error").fadeIn(300);

                    setTimeout(() => { $("#pop-up-error").fadeOut(300); }, 3000);
                }
                else {
                    $("#pop-up-error ul li").text("");
                    $("#pop-up-error ul li").text("Gagal Menyimpan Perubahan")
                    $("#pop-up-error").fadeIn(300);

                    setTimeout(() => { $("#pop-up-error").fadeIn(300); }, 3000);
                }


                $sel.data('prevent-change', true);
                $sel.val(prevVal).trigger('change');
                setTimeout(function () { $sel.data('prevent-change', false); }, 0);
            },
            complete: function () {
                $sel.prop('disabled', false);
            }
        });
    });

    // handler untuk perubahan dosen penguji 2
    $(document).on('change', '.dosen-penguji-2-select', function () {
        var $sel = $(this);

        // Mencegah loop berulang
        if ($sel.data('prevent-change')) return;

        var prevVal = $sel.data('prev-id');
        var jadwalId = $sel.data('id');
        var dosenPenguji2 = $sel.val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!jadwalId) return;

        $.ajax({
            url: '/panitia/jadwal-sidang-akhir/update-penguji-sidang-akhir-2',
            method: 'PUT',
            data: {
                jadwal_id: jadwalId,
                dosen_penguji_2_id: dosenPenguji2
            },
            headers: {
                'X-CSRF-TOKEN': token
            },
            beforeSend: function () {
                $sel.prop('disabled', true);
            },
            success: function (response) {
                // opsional: notif sukses sederhana
                console.log('Update penguji 2 sukses');
                $sel.data('prev-id', dosenPenguji2);

                console.log(response);

                if (response.message) {
                    $("#pop-up-success strong").text("");
                    $("#pop-up-success strong").text(response.message);
                    $("#pop-up-success").fadeIn(300);

                    setTimeout(() => { $("#pop-up-success").fadeOut(300); }, 3000);
                }
                else {
                    $("#pop-up-success strong").text("");
                    $("#pop-up-success strong").text("Berhasil mengubah Dosen Penguji Seminar Proposal 2");
                    $("#pop-up-success").fadeIn(300);

                    setTimeout(() => { $("#pop-up-success").fadeOut(300); }, 3000);
                }
            },
            error: function (xhr) {
                console.error('Gagal update penguji 2');

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    // alert(xhr.responseJSON.message);
                    $("#pop-up-error ul").text("");
                    $("#pop-up-error ul").text(xhr.responseJSON.message)
                    $("#pop-up-error").fadeIn(300);

                    setTimeout(() => { $("#pop-up-error").fadeOut(300); }, 3000);
                }
                else {
                    $("#pop-up-error ul li").text("");
                    $("#pop-up-error ul li").text("Gagal Menyimpan Perubahan")
                    $("#pop-up-error").fadeIn(300);

                    setTimeout(() => { $("#pop-up-error").fadeIn(300); }, 3000);
                }


                $sel.data('prevent-change', true);
                $sel.val(prevVal).trigger('change');
                setTimeout(function () { $sel.data('prevent-change', false); }, 0);
            },
            complete: function () {
                $sel.prop('disabled', false);
            }
        });
    });
});