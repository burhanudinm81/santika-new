$("document").ready(function () {
    $("#ubah-email-btn").click(function () {
        const paragraphEmail = $("#email-text");
        const inputEmail = $("input[name='email']");

        if (inputEmail.attr('type') === 'hidden') {
            $(this).text('Simpan Email');

            inputEmail.text(paragraphEmail.text());
            paragraphEmail.hide();
            inputEmail.attr('type', 'email');
        } else if (inputEmail.attr('type') === 'email') {
            // Simpan perubahan email
            const newEmail = inputEmail.val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const updateEmailUrl = '/admin-prodi/profile/edit-email';
            const data = {
                "email": newEmail,
                "_token": csrfToken
            };

            $.ajax({
                url: updateEmailUrl,
                method: 'PATCH',
                data: data,
                dataType: 'json',
            })
                .done(function (response) {
                    // Menampilkan pop up sukses
                    $("#modal-popup-sukses .modal-body").text(response.message);
                    $("#modal-popup-sukses").modal();

                    // Memuat halaman profil dosen ketika Modal Popup di sembunyikan
                    $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                        paragraphEmail.text(response.data.email);
                    });
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    const errorMessage = jqXHR.responseJSON.message;

                    // Me-reset Pop Up Error
                    $("#modal-popup-error .modal-body").text("");

                    $("#modal-popup-error .modal-body").text(errorMessage);
                    $("#modal-popup-error").modal();
                })
                .always(function (jqXHR, status) {
                    $(this).text('Ubah Email');
                    inputEmail.attr('type', 'hidden');
                    paragraphEmail.show();
                });
        }
    });

    $("#ganti-password-btn").click(function () {
        $("#form-ganti-password").find("input[name='current_password']").val("");
        $("#form-ganti-password").find("input[name='new_password']").val("");
        $("#form-ganti-password").find("input[name='new_password_confirmation']").val("");

        // Tampilkan modal untuk ganti password
        $("#modal-ganti-password").modal();
    });

    // --- LOGIKA UNTUK MENAMPILKAN/SEMBUNYIKAN PASSWORD ---
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

    $("#form-ganti-password").submit(function (event) {
        event.preventDefault();

        // Sembunyikan Modal Ganti Password
        $("#modal-ganti-password").modal('hide');

        const url = $(this).attr("action");
        const method = $(this).find("input[name='_method']").val();

        const formData = $(this).serialize();

        $.ajax({
            url: url,
            method: method,
            data: formData,
            dataType: "json"
        })
            .done(function (response) {
                console.log("done() is running");

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(response.message);
                $("#modal-popup-sukses").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                const errors = jqXHR.responseJSON.errors;
                const message = jqXHR.responseJSON.message;

                // Reset Pop Up Error
                $("#modal-popup-error .modal-body").text("");

                if (errors) {
                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errors[field].forEach(function (error) {
                                $("#modal-popup-error .modal-body").append("<p>" + error + "</p>");
                            });
                        }
                    }
                } else {
                    $("#modal-popup-error .modal-body").text(message);
                }

                $("#modal-popup-error").modal();
            });
    });
});
