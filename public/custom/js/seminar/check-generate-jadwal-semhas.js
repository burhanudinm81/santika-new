$(document).ready(function () {
    $("select[name='periode_id'], select[name='tahap_id']").on("change", function () {
        cekJumlahProposal();
    });

    $("#tambah-ruang, #tambah-tanggal").on("click", function () {
        cekJumlahProposal().then((jumlahProposal) => {
            changeButtonState(jumlahProposal);
        });
    });

    $(document).on("click", ".remove-ruang, .remove-tanggal", function () {
        cekJumlahProposal().then((jumlahProposal) => {
            changeButtonState(jumlahProposal);
        });
    });

    $("input[name='jumlah_sesi']").on("change", function () {
        cekJumlahProposal().then((jumlahProposal) => {
            changeButtonState(jumlahProposal);
        });
    });
});

function cekJumlahProposal() {
    return new Promise((resolve, reject) => {
        const periodeId = $("select[name='periode_id']").val();
        const tahapId = $("select[name='tahap_id']").val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (periodeId && tahapId) {
            $.ajax({
                url: '/panitia/jadwal-sidang-akhir/cek-jumlah-proposal',
                method: 'POST',
                data: {
                    periode_id: periodeId,
                    tahap_id: tahapId,
                    _token: csrfToken
                },
                success: function (response) {
                    if (response.status) {
                        $(".jumlah-proposal").text(response.data.jumlah_proposal);
                        resolve(response.data.jumlah_proposal);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON.message);
                }
            });
        }
        else {
            reject("Input tidak valid");
        }
    });
}

function changeButtonState(jumlahProposal) {
    const jumlahRuang = $('#ruang-table-body tr').length;
    const jumlahTanggal = $('#tanggal-table-body tr').length;
    const jumlahSesi = parseInt($("input[name='jumlah_sesi']").val()) || 0;

    let totalRHS = jumlahRuang * jumlahTanggal * jumlahSesi;
    $("#total-rhs").text(totalRHS);

    if (jumlahProposal >= jumlahRuang * jumlahTanggal * jumlahSesi) {
        $("#btn-generate-jadwal").prop("disabled", true);
    }
    else {
        $("#btn-generate-jadwal").prop("disabled", false);
    }
}