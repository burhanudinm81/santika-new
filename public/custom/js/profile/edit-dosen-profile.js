$("document").ready(function () {
    $("#edit-profile-btn").click(function () {
        $(".content-wrapper").load("/dosen/profile/edit");
    });

    $("#btn-batal").click(function () {
        $(".content-wrapper").load("/dosen/profile");
    });

    $("#btn-simpan").click(function (event) {
        event.preventDefault();

        // Mengambil data dari form
        const data = new FormData($("#form-edit-profil-dosen")[0]);

        $.ajax({
            url: $("#form-edit-profil-dosen").attr("action"),
            method: "POST",
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                const message = response.message;

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(message);
                $("#modal-popup-sukses").modal();

                // Memuat halaman profil dosen ketika Modal Popup di sembunyikan
                $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                    $(".content-wrapper").load("/dosen/profile");
                });
            },
            error: function (jqXHR, status, error) {
                const errorMessage = jqXHR.responseJSON.message;

                // Me-reset Pop Up Error
                $("#modal-popup-error .modal-body").text("");

                // Menyiapkan pesan error
                let errorList = $("<ul></ul>");

                for (const attribute in errorMessage) {
                    if (errorMessage[attribute]) {
                        errorMessage[attribute].forEach(function (error) {
                            let errorMsg = $(`<li>${error}</li>`);
                            errorMsg.appendTo(errorList);
                        });
                    }
                }

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").append(errorList);
                $("#modal-popup-error").modal();
            }
        });
    });
});