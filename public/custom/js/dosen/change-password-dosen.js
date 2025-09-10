$("document").ready(function () {
    const tableBody = $("#dosen-table-body");
    const modalGantiPassword = $("#modal-ganti-password-dosen");
    const formGantiPassword = $("#form-ganti-password-dosen");

    tableBody.on("click", ".btn-ganti-password", function () {
        const dosenId = $(this).data("id");
        const namaDosen = $(this).data("nama");

        formGantiPassword.find("input[name='dosen_id']").val(dosenId);
        formGantiPassword.find("#nama-dosen").val(namaDosen);
        formGantiPassword.find("input[name='new_password']").val("");
        formGantiPassword.find("input[name='new_password_confirmation']").val("");

        modalGantiPassword.modal("show");
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

    formGantiPassword.submit(function (event) {
        // Mencegah form submit secara default
        event.preventDefault();

        // Menutup Modal Ganti Password
        modalGantiPassword.modal("hide");

        const url = $(this).attr("action");
        const method = $(this).find("input[name='_method']").val() || "PATCH";
        const formData = formGantiPassword.serialize();

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
                const message = jqXHR.responseJSON.message;
                const errors = jqXHR.responseJSON.errors;

                // Reset isi modal error
                $("#modal-popup-error .modal-body").text("");

                if (errors) {
                    if (errors.hasOwnProperty('new_password')) {
                        errors['new_password'].forEach(error => {
                            $("#modal-popup-error .modal-body").append(`<p>${error}</p>`);
                        });
                    }
                } else {
                    $("#modal-popup-error .modal-body").text(message);
                }

                // Menampilkan pop up error
                $("#modal-popup-error").modal();
            }
        });
    });
});