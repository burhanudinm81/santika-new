$("document").ready(function(){
    $("#simpan-foto-profil-btn").click(function(){
        // Mengambil data dari form
        const data = new FormData($("#form-ubah-foto-profil")[0]);

        $.ajax({
            url: $("#form-ubah-foto-profil").attr("action"),
            method: "POST",
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response){
                const message = response.message;

                // Menutup Modal Ubah Foto Profil
                $("#modal-ubah-foto-profil").modal('hide');

                // Menampilkan pop up sukses
                $("#modal-popup-sukses .modal-body").text(message);
                $("#modal-popup-sukses").modal();

                // Refresh Profil ketika Modal Popup di sembunyikan
                $("#modal-popup-sukses").on("hidden.bs.modal", function(){
                    $("#user-image").attr("src", response.info.image_url);
                    $(".profile-user-img").attr("src", response.info.image_url)
                });
            },
            error: function(jqXHR, status, error){
                const errorMessage = jqXHR.responseJSON.message;
                
                // Menutup Modal Ubah Foto Profil
                $("#modal-ubah-foto-profil").modal('hide');

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();
            }
        });
    });
});