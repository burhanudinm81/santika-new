$("document").ready(function(){
    $("#form-daftar-sempro").submit(function(event){
        event.preventDefault();

        const data = new FormData($(this)[0]);

        console.log("Form Daftar Sempro disubmit");

        $.ajax({
            url: $(this).attr("action"),
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

                // Memuat halaman ??? ketika Modal Popup di sembunyikan
                // $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                //     $(".content-wrapper").load("");
                // });
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
        })
    });
});