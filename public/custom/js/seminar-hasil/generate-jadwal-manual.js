$(document).ready(function(){
    $('#pilih-periode-tahap').click(function(){
        const periodeId = $("select[name='periode_id']").val();
        const tahapId = $("select[name='tahap_id']").val();
        const tableBody = $("#tbody-daftar-calon-peserta");

        $.get("/panitia/jadwal-sidang-akhir/calon-peserta", {periode_id: periodeId, tahap_id: tahapId})
            .done(function(data){
                tableBody.empty();

                console.log(data);

                if(data.status){
                    const listProposal = data.data.listProposal;
                    const listDosenPenguji1 = data.data.listDosenPenguji1;
                    const listDosenPenguji2 = data.data.listDosenPenguji2;
                    const prodi = parseInt(data.data.prodi);

                    $.each(listProposal, function(index, item){
                        const row = `
                            <tr>
                                <input type="hidden" name="proposal_id[${index}]" value="${item.id}">
                                <td style="width: 25px">${index + 1}</td>
                                <td><input style="width: 100px" type='text' class="form-control" name='ruang[${index}]' required></td>
                                <td><input type='date' class="form-control" name='tanggal[${index}]' required></td>
                                <td><input style="width: 75px" type='number' class="form-control" name='sesi[${index}]' required></td>
                                <td><input type='time' class="form-control" name='waktu_mulai[${index}]' required></td>
                                <td><input type='time' class="form-control" name='waktu_selesai[${index}]' required></td>
                                <td>${item.judul}</td>
                                <td>${item.proposal_mahasiswas[0].mahasiswa.nama}</td>
                                ${prodi === 1 ? `<td>${item.proposal_mahasiswas[0].mahasiswa.nama}</td>` : `""`}
                                <td>${item.dosen_pembimbing1.nama}</td>
                                <td>${item.dosen_pembimbing2.nama}</td>
                                <td>
                                    <select name='dosen_penguji_1_id[${index}]' class="form-control" required>
                                        ${listDosenPenguji1.map(dosen => `
                                            <option value="${dosen.id}">${dosen.nama}</option>
                                        `).join('')}
                                    </select>
                                </td>
                                <td>
                                    <select name='dosen_penguji_2_id[${index}]' class="form-control" required>
                                        ${listDosenPenguji2.map(dosen => `
                                            <option value="${dosen.id}">${dosen.nama}</option>
                                        `).join('')}
                                    </select>
                                </td>
                            <tr>
                        `;
    
                        tableBody.append(row);
                    });

                    const button = '<button type="submit" class="btn btn-success mt-4">Buat Jadwal</button>';
                    tableBody.append(button);
                } else {
                    tableBody.html('<tr><td colspan="12" class="text-center">Data tidak ditemukan.</td></tr>');
                }
            });
    });
});