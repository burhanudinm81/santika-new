$(document).ready(function () {
    $('#btn-publish-nilai-sempro').click(function () {
        // Mengisi input periode_id dan membuka modal publish rekap nilai sempro
        $('#modal-publish-rekap-nilai-sempro')
            .find('input[name="periode_id"]')
            .val($('#periode_sempro_id').val());
        $('#modal-publish-rekap-nilai-sempro').modal('show');
    });

    $('#btn-hide-nilai-sempro').click(function () {
        // Mengisi input periode_id dan membuka modal hide rekap nilai sempro
        $('#modal-hide-rekap-nilai-sempro')
            .find('input[name="periode_id"]')
            .val($('#periode_sempro_id').val());
        $('#modal-hide-rekap-nilai-sempro').modal('show');
    });

    $('#btn-publish-nilai-semhas').click(function () {
        // Mengisi input periode_id dan membuka modal publish rekap nilai semhas
        $('#modal-publish-rekap-nilai-semhas')
            .find('input[name="periode_id"]')
            .val($('#periode_semhas_id').val());
        $('#modal-publish-rekap-nilai-semhas').modal('show');
    });

    $('#btn-hide-nilai-semhas').click(function () {
        // Mengisi input periode_id dan membuka modal hide rekap nilai semhas
        $('#modal-hide-rekap-nilai-semhas')
            .find('input[name="periode_id"]')
            .val($('#periode_semhas_id').val());
        $('#modal-hide-rekap-nilai-semhas').modal('show');
    });
});
