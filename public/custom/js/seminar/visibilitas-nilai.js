$(document).ready(function(){
    $('#btn-publish-nilai').click(function(){
        $('#modal-publish-rekap-nilai-sempro')
            .find('input[name="periode_id"]')
            .val($('#periode_sempro_id').val());
        $('#modal-publish-rekap-nilai-sempro').modal('show');
    });

    $('#btn-hide-nilai').click(function(){
        $('#modal-hide-rekap-nilai-sempro')
            .find('input[name="periode_id"]')
            .val($('#periode_sempro_id').val());
        $('#modal-hide-rekap-nilai-sempro').modal('show');
    });
});
