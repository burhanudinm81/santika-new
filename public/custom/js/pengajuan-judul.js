$("document").ready(function () {
    $("#bidang").on("change", function () {
        const bidangKeahlian = $("#bidang").val();
        console.log(`Bidang Keahlian: ${bidangKeahlian}`);

        const data = {
            _token: $("meta[name='csrf-token']").attr("content"),
            bidang_keahlian: bidangKeahlian
        };

        $.ajax({
            url: "/mahasiswa/pengajuan-judul/list-dosen",
            method: "POST",
            data: data,
            dataType: "json",
            success: function (response) {
                const data = JSON.parse(response.data);
                const calonDosenPembimbing1 = $("#calon-dosen-pembimbing-1");
                calonDosenPembimbing1.html("");

                data.forEach(dosen => {
                    const option = $(`<option value="${dosen.id}">${dosen.nama}</option>`);
                    option.appendTo(calonDosenPembimbing1);
                });
            },
            error: function (jqXHR, status, error) {
                const errorMessage = jqXHR.responseJSON.message;
                console.log(errorMessage);
            }
        })
    });

    $("#form-pengajuan-judul").submit(function (event) {
        event.preventDefault();
        console.log("Pengajuan Judul Dikirim");

        const data = new FormData($("#form-pengajuan-judul")[0]);

        $.ajax({
            url: $("#form-pengajuan-judul").attr("action"),
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

                // Ketika Pop Sukses ditutup, langsung buka halaman Riwayat Pengajuan
                $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                    $(".content-wrapper").load("/mahasiswa/pengajuan-judul/riwayat");
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

    $(".buka-detail-button").click(function (event) {
        event.preventDefault();

        const link = $(this).attr("href");
        $(".content-wrapper").load(link, function (response, status, xhr) {
            if (xhr.status === 403) {
                $(".content").html("");
                $(".content").append(response);
            }
        });
    });

    $("#form-konfirmasi-permohonan-judul .terima-btn").click(function (event) {
        event.preventDefault();

        konfirmasiPermohonanJudul($("#form-konfirmasi-permohonan-judul"), $(this));
    });

    $("#form-konfirmasi-permohonan-judul .tolak-btn").click(function (event) {
        event.preventDefault();

        konfirmasiPermohonanJudul($("#form-konfirmasi-permohonan-judul"), $(this));
    });
});

function konfirmasiPermohonanJudul(form, buttonClicked) {
    const data = {
        _token: form.find("input[name='_token']").val(),
        id_pengajuan: form.find("input[name='id_pengajuan']").val(),
        prodi: form.find("input[name='prodi']").val(),
        aksi: $(buttonClicked).val()
    };

    $.ajax({
        url: form.attr("action"),
        method: form.attr("method"),
        data: data,
        dataType: "json",
        success: function (response) {
            const message = response.message;

            // Menampilkan pop up sukses
            $("#modal-popup-sukses .modal-body").text(message);
            $("#modal-popup-sukses").modal();

            // Ketika Pop Sukses ditutup, langsung buka halaman Permohonan Judul
            $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                $(".content-wrapper").load("/dosen/permohonan-judul");
            });
        },
        error: function (jqXHR, status, error) {
            const errorMessage = jqXHR.responseJSON.message;

            // Me-reset Pop Up Error
            $("#modal-popup-error .modal-body").text("");

            if (jqXHR.status === 422) {
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
            else if (jqXHR.status === 403) {
                const errorMessage = jqXHR.responseJSON.message;

                // Menampilkan pop up error
                $("#modal-popup-error .modal-body").text(errorMessage);
                $("#modal-popup-error").modal();

                // Ketika Popup Error ditutup, langsung buka halaman Permohonan Judul
                $("#modal-popup-error").on("hidden.bs.modal", function () {
                    $(".content-wrapper").load("/dosen/permohonan-judul");
                });
            }
        }
    });
}