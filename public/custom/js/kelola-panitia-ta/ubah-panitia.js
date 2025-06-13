$("document").ready(function () {
    // Elemen overlay spinner
    const $loadingOverlay = $('#loading-overlay');

    // URL halaman Daftar Pantia Tugas akhir
    const daftarPanitiaTAUrl = "/admin-prodi/panitia-tugas-akhir";

    function muatHalaman(url) {
        // TAMPILKAN SPINNER SEBELUM REQUEST
        $loadingOverlay.css('display', 'flex').hide().fadeIn(200);

        $.get(url)
            .done(function (data) {
                // Masukkan konten jika berhasil
                $(".content-wrapper").html(data);
                console.log("Halaman " + url + " Berhasil Dimuat!");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                // Tampilkan pesan error jika gagal
                $(".content-wrapper").html("<div class='alert alert-danger'>Halaman Gagal Dimuat. Silakan coba lagi.</div>");
                console.error("Gagal memuat " + url + ": ", errorThrown);
            })
            .always(function () {
                // SELALU SEMBUNYIKAN SPINNER SETELAH REQUEST SELESAI
                $loadingOverlay.fadeOut(200);
            });
    }

    // Jika Tombol batal diklik, kembali ke halaman Panitia Tugas Akhir
    $("#batal").click(function () {
        muatHalaman(daftarPanitiaTAUrl);
    });

    // Jika Form Panitia TA disubmit, simpan data Panitia TA yang dikirim
    $(".form-panitia").submit(function (event) {
        event.preventDefault();

        // Ambil referensi ke form
        const form = $(this);

        // Ambil semua data dari form (termasuk _token CSRF)
        const formData = form.serialize();

        // Ambil URL dan Method dari atribut form
        const url = form.attr('action');
        const method = form.attr('method');

        // Reset pop up error
        $("#modal-popup-error .modal-body").text("");

        // TAMPILKAN SPINNER SEBELUM REQUEST
        $loadingOverlay.css('display', 'flex').hide().fadeIn(200);

        // Mengirim data ke Server menggunakan method POST
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

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();
            },
            complete: function () {
                // SELALU SEMBUNYIKAN SPINNER SETELAH REQUEST SELESAI
                $loadingOverlay.fadeOut(200);

                // Jika Modal/Pop Up Sukses atau Pop Up Error ditutup kembalikan ke halaman Daftar Panitia TA
                $("#modal-popup-sukses, #modal-popup-error").on("hidden.bs.modal", function () {
                    muatHalaman(daftarPanitiaTAUrl);
                });
            }
        });
    });
});