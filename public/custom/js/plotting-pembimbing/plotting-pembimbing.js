document.addEventListener('DOMContentLoaded', function () {
    main();
});

function main() {
    document.querySelectorAll('.btn-warning').forEach(button => {
        button.addEventListener('click', function () {
            const prodiId = parseInt(this.getAttribute('data-prodi-id'));
            const editModalD3 = $('#editModalD3');
            const editModalD4 = $('#editModalD4');

            const row = this.closest('tr');
            let namaMahasiswa1, namaMahasiswa2, dosenPembimbing1, dosenPembimbing2;

            const proposalId = row.getAttribute('data-proposal-id');
            const dosenPembimbing1Id = row.getAttribute('data-dosbing1-id');
            const dosenPembimbing2Id = row.getAttribute('data-dosbing2-id');

            if (prodiId === 1) {
                namaMahasiswa1 = row.querySelector('td:nth-child(3)').textContent.trim();
                namaMahasiswa2 = row.querySelector('td:nth-child(5)').textContent.trim();
                dosenPembimbing1 = row.querySelector('td:nth-child(6)').textContent.trim();
                dosenPembimbing2 = row.querySelector('td:nth-child(7)').textContent.trim();

                editModalD3.find('input[name="proposal_id"]').val(proposalId);
                editModalD3.find('#nama-mahasiswa-1').val(namaMahasiswa1);
                editModalD3.find('#nama-mahasiswa-2').val(namaMahasiswa2);
                editModalD3.find("#dosen-pembimbing-1").val(dosenPembimbing1Id);
                editModalD3.find("#dosen-pembimbing-2").val(dosenPembimbing2Id);

                editModalD3.modal('show');
            }
            else {
                namaMahasiswa1 = row.querySelector('td:nth-child(3)').textContent.trim();
                dosenPembimbing1 = row.querySelector('td:nth-child(4)').textContent.trim();
                dosenPembimbing2 = row.querySelector('td:nth-child(5)').textContent.trim();

                editModalD4.find('input[name="proposal_id"]').val(proposalId);
                editModalD4.find('#nama-mahasiswa').val(namaMahasiswa1);
                editModalD4.find("#dosen-pembimbing-1").val(dosenPembimbing1Id);
                editModalD4.find("#dosen-pembimbing-2").val(dosenPembimbing2Id);

                editModalD4.modal('show');
            }

            // Simpan perubahan ketika klik "Save changes"
            document.querySelectorAll('.save-changes').forEach(button => {
                button.addEventListener('click', function () {
                    const modal = this.closest('.modal');
                    const form = modal.querySelector('form');

                    // Submit Form
                    form.submit()

                    // Tutup modal setelah perubahan disimpan
                    modal.modal('hide');
                });
            });
        });
    });
}