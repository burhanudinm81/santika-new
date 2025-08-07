$(document).ready(function () {

    $('#buttonTampilNilaiSemhasByPeriode').click(function () {
        const periodeId = $('#periode_semhas_id').val();
        const tahapId = $('#tahap_semhas_id').val();
        const prodiPanitiaId = $('#prodi_panitia_semhas_id').val();

        if (!periodeId || !tahapId) {
            alert('Periode dan Tahap harus dipilih');
            return;
        }

        // /panitia/ajax/list-rekap-nilai-sempro <- url
        $.ajax({
            url: '/panitia/ajax/list-rekap-nilai-semhas',
            method: 'GET',
            data: {
                periode_id: periodeId,
                tahap_id: tahapId,
                prodi_panitia_id: prodiPanitiaId
            },
            success: function (response) {
                let tbody = '';

                if (response.length === 0) {
                    tbody = `<tr><td colspan="6" class="text-center">Belum ada data</td></tr>`;
                } else {
                    response.forEach((item, index) => {
                        const test = item.proposal_mahasiswas[0].mahasiswa;

                        let badge = '';
                        const statusSempro = item.status_semhas_total.id;
                        if (statusSempro == 1) {
                            badge = `<span class="badge badge-success">${item.status_semhas_total.status}</span>`;
                        } else if (statusSempro == 2) {
                            badge = `<span class="badge badge-primary">${item.status_semhas_total.status}</span>`;
                        } else if (statusSempro == 3) {
                            badge = `<span class="badge badge-danger">${item.status_semhas_total.status}</span>`;
                        }

                        if (prodiPanitiaId == 1) {
                            tbody += `
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[1].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[1].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-hasil/detail-verifikasi-revisi/${item.id}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        } else if (prodiPanitiaId == 2) {
                            tbody += `
                                 <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-hasil/detail-verifikasi-revisi/${item.id}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        }


                    });
                }

                $('#data-table-body').html(tbody);
            },
            error: function (xhr) {
                alert('Terjadi kesalahan saat memuat data rekap nilai semhas.');
            }
        });
    });

    $('#buttonTampilByPeriodeSemhas').click(function () {
        const periodeId = $('#periode_id').val();
        const tahapId = $('#tahap_id').val();
        const prodiPanitiaId = $('#prodi_panitia_id').val();

        if (!periodeId || !tahapId) {
            alert('Periode dan Tahap harus dipilih');
            return;
        }

        $.ajax({
            url: '/panitia/ajax/list-pendaftaran-semhas',
            method: 'GET',
            data: {
                periode_id: periodeId,
                tahap_id: tahapId,
                prodi_panitia_id: prodiPanitiaId
            },
            success: function (response) {
                let tbody = '';

                if (response.length === 0) {
                    tbody = `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`;
                } else {
                    response.forEach((item, index) => {
                        const test = item.proposal.proposal_mahasiswas[0].mahasiswa;

                        let badge = '';
                        const statusPendaftaranSempro = item.status_daftar_semhas_id;
                        if (statusPendaftaranSempro == 1) {
                            badge = `<span class="badge badge-success">Diterima</span>`;
                        } else if (statusPendaftaranSempro == 2) {
                            badge = `<span class="badge badge-danger">Ditolak</span>`;
                        } else if (statusPendaftaranSempro == 3) {
                            badge = `<span class="badge badge-warning">Belum Dicek</span>`;
                        }

                        if (prodiPanitiaId == 1) {
                            tbody += `
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[1].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[1].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-hasil/pendaftaran/${item.id}/verifikasi" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        } else if (prodiPanitiaId == 2) {
                            tbody += `
                                 <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-hasil/pendaftaran/${item.id}/verifikasi" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        }


                    });
                }

                $('#data-table-body').html(tbody);
            },
            error: function (xhr) {
                alert('Terjadi kesalahan saat memuat data.');
            }
        });
    });


});
