$(document).ready(function () {
    $('.toggle-password').on('click', function () {
        // Ambil elemen input yang ditargetkan dari atribut data-target
        const target = $(this).data('target');
        const passwordInput = $(target);

        // Ambil elemen ikon di dalam tombol yang diklik
        const icon = $(this).find('i');

        // Cek tipe input saat ini
        if (passwordInput.attr('type') === 'password') {
            // Jika tipenya password, ubah menjadi text
            passwordInput.attr('type', 'text');
            // Ubah ikonnya menjadi mata-tercoret
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            // Jika tipenya text, kembalikan menjadi password
            passwordInput.attr('type', 'password');
            // Kembalikan ikonnya menjadi mata
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});