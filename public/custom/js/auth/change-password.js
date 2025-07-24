$(document).ready(function() {

    // --- LOGIKA UNTUK MENAMPILKAN/SEMBUNYIKAN PASSWORD ---
    $('.toggle-password').on('click', function() {
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

    $('#save-password-btn').on('click', function () {
        $('#form-ubah-password').trigger('submit');
    });

    // --- LOGIKA UNTUK SUBMIT FORM VIA AJAX ---
    $('#form-ubah-password').on('submit', function(event) {
        event.preventDefault();

        const form = $(this);
        const submitButton = $('#save-password-btn');
        const formData = form.serialize();
        const url = form.attr('action');

        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#validation-errors').hide().empty();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            beforeSend: function() {
                submitButton.prop('disabled', true).text('Menyimpan...');
            },
            success: function(response) {
                const redirectUrl = response.redirect_url || '/logout';
                alert('Password berhasil diubah! Anda akan diarahkan untuk login ulang.');
                window.location.href = redirectUrl;
            },
            error: function(jqXHR) {
                if (jqXHR.status === 422) { // Error validasi
                    const errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '_error').text(value[0]);
                        
                        let input = null;
                        if (key === 'new_password_confirmation') {
                            input = $('#confirm-password');
                        } else {
                            input = $('#' + key);
                        }
                        input.addClass('is-invalid');
                    });
                } else { // Error lain
                    const message = (jqXHR.responseJSON && jqXHR.responseJSON.message) 
                                    ? jqXHR.responseJSON.message 
                                    : 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    $('#validation-errors').text(message).show();
                }
            },
            complete: function() {
                submitButton.prop('disabled', false).text('Simpan');
            }
        });
    });

});