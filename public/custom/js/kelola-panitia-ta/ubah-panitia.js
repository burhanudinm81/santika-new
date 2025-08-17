$("document").ready(function () {
    let daftarPanitiaTAUrl = "/admin-prodi/panitia-tugas-akhir";
    const $loadingOverlay = $('#loading-overlay');

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
                    document.location.href = daftarPanitiaTAUrl;
                });
            }
        });
    });
});