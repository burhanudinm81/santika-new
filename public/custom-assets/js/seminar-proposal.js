$(document).ready(function () {

    $('#buttonTampilNilaiSemproByPeriode').click(function () {
        const periodeId = $('#periode_sempro_id').val();
        const tahapId = $('#tahap_sempro_id').val();
        const prodiPanitiaId = $('#prodi_panitia_sempro_id').val();

        if (!periodeId || !tahapId) {
            alert('Periode dan Tahap harus dipilih');
            return;
        }

        // /panitia/ajax/list-rekap-nilai-sempro <- url
        $.ajax({
            url: '/panitia/ajax/list-rekap-nilai-sempro',
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
                        const statusSempro = item.status_sempro_total.id;
                        if (statusSempro == 1) {
                            badge = `<span class="badge badge-success">${item.status_sempro_total.status}</span>`;
                        } else if (statusSempro == 2) {
                            badge = `<span class="badge badge-primary">${item.status_sempro_total.status}</span>`;
                        } else if (statusSempro == 3) {
                            badge = `<span class="badge badge-danger">${item.status_sempro_total.status}</span>`;
                        }

                        if (prodiPanitiaId == 1) {
                            tbody += `
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas?.[1]?.mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas?.[1]?.mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle" style="width: 250px">${item.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-proposal/detail-verifikasi-revisi/${item.id}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        } else if (prodiPanitiaId == 2) {
                            tbody += `
                                 <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle" style="width: 250px">${item.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-proposal/detail-verifikasi-revisi/${item.id}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            `;
                        }


                    });
                }

                $('#data-table-body').html(tbody);
            },
            error: function (xhr) {
                alert('Terjadi kesalahan saat memuat data rekap nilai sempro.');
            }
        });
    });

    $('#buttonTampilByPeriode').click(function () {
        const periodeId = $('#periode_id').val();
        const tahapId = $('#tahap_id').val();
        const prodiPanitiaId = $('#prodi_panitia_id').val();

        if (!periodeId || !tahapId) {
            alert('Periode dan Tahap harus dipilih');
            return;
        }

        $.ajax({
            url: '/panitia/ajax/list-pendaftaran-sempro',
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
                        const statusPendaftaranSempro = item.status_daftar_sempro_id;
                        if (statusPendaftaranSempro == 1) {
                            badge = `<span class="badge badge-success">Diterima</span>`;
                        } else if (statusPendaftaranSempro == 2) {
                            badge = `<span class="badge badge-danger">Ditolak</span>`;
                        } else if (statusPendaftaranSempro == 3) {
                            badge = `<span class="badge badge-warning">Belum Dicek</span>`;
                        }

                        if (prodiPanitiaId == 1) {
                            const hasMahasiswa2 = item.proposal.proposal_mahasiswas && item.proposal.proposal_mahasiswas.length > 1;
                            console.log(hasMahasiswa2);

                            tbody += `
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                            `;

                            if (hasMahasiswa2) {
                                tbody += `
                                <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[1].mahasiswa.nama ?? '-'}</td>
                                <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[1].mahasiswa.nim ?? '-'}</td>
                                `;
                            } else {
                                tbody += `
                                <td class="text-center align-middle">-</td>
                                <td class="text-center align-middle">-</td>
                                `
                            }



                            tbody += `<td class="text-center align-middle td-250-wrapper">${item.proposal.judul ?? 's-'}</td>
                            <td class="text-center align-middle">
                                ${badge}
                            </td>
                            <td class="text-center align-middle">
                                <a href="/panitia/seminar-proposal/pendaftaran/${item.id}/verifikasi" class="btn btn-primary btn-sm">View</a>
                            </td>
                            </tr>
                            `;
                        } else if (prodiPanitiaId == 2) {
                            tbody += `
                                 <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nama ?? '-'}</td>
                                    <td class="text-center align-middle">${item.proposal.proposal_mahasiswas[0].mahasiswa.nim ?? '-'}</td>
                                    <td class="text-center align-middle td-250-wrapper">${item.proposal.judul ?? '-'}</td>
                                    <td class="text-center align-middle">
                                        ${badge}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/panitia/seminar-proposal/pendaftaran/${item.id}/verifikasi" class="btn btn-primary btn-sm">View</a>
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
