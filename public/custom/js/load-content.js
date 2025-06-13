$(document).ready(function() {

    // Elemen overlay spinner
    const $loadingOverlay = $('#loading-overlay');

    // Fungsi untuk memuat konten 
    function loadContent(url) {
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
    }

    // Muat konten dashboard saat halaman home berhasil dimuat
    const dashboardUrl = $("#dashboard-item").find("a").attr("href");
    if (dashboardUrl) {
        loadContent(dashboardUrl);
    }

    // Tangani klik pada semua link di dalam .nav-item
    $('.nav-ajax').click(function(event) {
        event.preventDefault();
        const targetUrl = $(this).find("a").attr('href');
        loadContent(targetUrl);
    });

});