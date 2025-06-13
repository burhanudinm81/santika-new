$("document").ready(function () {
    // Ketika Form Edit Email di submit jalankan kode dibawah
    $("#edit-email-form").submit(function (event) {
        event.preventDefault();

        // Mengambil data dari form edit email
        const data = {
            _token: $("input[name='_token']").val(),
            email: $("input[name='email']").val()
        }

        // Mengirim data ke server
        $.ajax({
            url: $("#edit-email-form").attr("action"),
            method: "POST",
            data: data,
            dataType: "json",
            success: function (response) {
                let message = response.message;

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(message);
                $("#modal-popup-sukses").modal();
            },
            error: function (jqXHR, status, error) {
                let errorMessage = jqXHR.responseJSON.message;

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();
            }
        });
    });
});
