$(document).ready(function(){
    $('#btn-ubah-periode-aktif').click(function(){
        $('#modal-ubah-periode-aktif').modal('show');
    });
    $('#btn-ubah-tahap-sempro').click(function(){
        $('#modal-ubah-tahap-sempro-aktif').modal('show');
    });
    $('#btn-ubah-tahap-sidang-ta').click(function(){
        $('#modal-ubah-tahap-sidang-ta-aktif').modal('show');
    });

    $('#btn-buka-pendaftaran-sempro').click(function(){
        $('#modal-buka-pendaftaran-sempro').modal('show');
    });
    $('#btn-buka-pendaftaran-sidang-ta').click(function(){
        $('#modal-buka-pendaftaran-sidang-ta').modal('show');
    });
    $('#btn-nonaktifkan-tahap-sempro').click(function(){
        $('#modal-tutup-pendaftaran-sempro').modal('show');
    });
    $('#btn-nonaktifkan-tahap-sidang-ta').click(function(){
        $('#modal-tutup-pendaftaran-sidang-ta').modal('show');
    });

    $('#btn-tambah-tahap').click(function(){
        $('#modal-tambah-tahap').modal('show');
    });
    $('#btn-tambah-periode').click(function(){
        $('#modal-tambah-periode').modal('show');
    });

    $(".btn-hapus-tahap").click(function(){
        var tahapId = $(this).data('tahap-id');
        $('#input-hapus-tahap').val(tahapId);
        $('#modal-hapus-tahap').modal('show');
    });
});
