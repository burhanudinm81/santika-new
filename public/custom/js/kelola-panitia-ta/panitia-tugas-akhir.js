$("document").ready(function () {
    // Elemen overlay spinner
    const $loadingOverlay = $('#loading-overlay');

    // Jika tombol tambah panitia di klik, maka buka halaman tambah panitia 
    $(".manage-panitia-btn").click(function(){
        const url = $(this).data("url");

        // TAMPILKAN SPINNER SEBELUM REQUEST
        $loadingOverlay.css('display', 'flex').hide().fadeIn(200);

        $.get(url)
            .done(function(data) {
                // Masukkan konten jika berhasil
                $(".content-wrapper").html(data);
                console.log("Halaman " + url + " Berhasil Dimuat!");
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Tampilkan pesan error jika gagal
                $(".content-wrapper").html("<div class='alert alert-danger'>Halaman Gagal Dimuat. Silakan coba lagi.</div>");
                console.error("Gagal memuat " + url + ": ", errorThrown);
            })
            .always(function() {
                // SELALU SEMBUNYIKAN SPINNER SETELAH REQUEST SELESAI
                $loadingOverlay.fadeOut(200);
            });
    });
});