$(document).ready(function(){
    $('.dosen-penguji-select').select2({
        theme: 'bootstrap4',
        width: 'resolve',
        placeholder: '-- Pilih Dosen --',
        allowClear: true,
        dropdownParent: $(document.body),
        dropdownAutoWidth: true,
        dropdownCss: {'max-width': 'calc(100vw - 20px)'}
    });
});