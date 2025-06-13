$("document").ready(function () {
    // Tampilkan semua dosen di tabel kuota dosen ketika pertama dimuat
    showAllDosen();

    let timeoutId;

    // Ketika Input Pencarian D3 di ketik, lakukan pencarian dosen
    $("#search-dosen-d3").keyup(function () {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(function () {
            let searchInputText = $.trim($("#search-dosen-d3").val());
            removeTable("d3");
            searchDosen(searchInputText, "d3");
        }, 500)
    });

    // Ketika Input Pencarian D4 di ketik, lakukan pencarian dosen
    $("#search-dosen-d4").keyup(function () {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(function () {
            let searchInputText = $.trim($("#search-dosen-d4").val());
            removeTable("d4");
            searchDosen(searchInputText, "d4");
        }, 500);
    });
});

function showAllDosen() {
    $.ajax({
        url: "/panitia/kuota-dosen/all",
        method: "GET",
        dataType: "json",
        success: function (response) {
            const data = JSON.parse(response.data);

            showKuotaDosenTable(data, "d3");
            showKuotaDosenTable(data, "d4");
        }
    });
}

function searchDosen(searchInputText, prodi) {
    // Token CSRF
    const token = $("meta[name='csrf-token']").attr('content');

    // Data yang akan dikirim ke Server
    const data = {
        _token: token,
        search: searchInputText
    };

    $.ajax({
        url: "/panitia/kuota-dosen/search",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (response) {
            const data = JSON.parse(response.data);
            console.log(data);
            showKuotaDosenTable(data, prodi);
        }
    });
}

function showKuotaDosenTable(data, prodi) {
    let table;

    if (prodi === "d3")
        table = $("#tabel-kuota-dosen-d3");
    else if (prodi === "d4")
        table = $("#tabel-kuota-dosen-d4");

    const tableBody = table.find("tbody");

    data.forEach(function (dosen, index) {
        const row = $("<tr></tr>");
        const nidn = $(`<input type='hidden' id='nidn' name='nidn' value='${dosen.NIDN}'>`);
        const numberCol = $(`<td class="text-center align-middle">${index + 1}</td>`);
        const nameCol = $(`<td class="text-center align-middle">${dosen.nama}</td>`);

        let kuotaDosenPembimbing1Col;
        let editButton;

        // console.log(dosen);

        if (prodi === "d3") {
            kuotaDosenPembimbing1Col = $(`
                    <td class="text-center align-middle">
                        <span class="value">${dosen.kuota_dosen.kuota_pembimbing_1_D3}</span>
                        <input class="value-edit" type="number" name="kuota_pembimbing_1" value="${dosen.kuota_dosen.kuota_pembimbing_1_D3}" style="display:none;">
                    </td>
                `);
            editButton = $(`
                    <td class="text-center align-middle">
                        <button class="btn btn-success btn-sm" onclick="editItem(this, 'd3')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                `);
        }
        else if (prodi === "d4") {
            kuotaDosenPembimbing1Col = $(`
                    <td class="text-center align-middle">
                        <span class="value">${dosen.kuota_dosen.kuota_pembimbing_1_D4}</span>
                        <input class="value-edit" type="number" name="kuota_pembimbing_1" value="${dosen.kuota_dosen.kuota_pembimbing_1_D4}" style="display:none;">
                    </td>
                `);
            editButton = $(`
                    <td class="text-center align-middle">
                        <button class="btn btn-success btn-sm" onclick="editItem(this, 'd4')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                `);
        }


        row.append(nidn);
        row.append(numberCol);
        row.append(nameCol);
        row.append(kuotaDosenPembimbing1Col);
        row.append(editButton);

        row.appendTo(tableBody);
    });
}

function removeTable(prodi) {
    let table;

    if (prodi === "d3")
        table = $("#tabel-kuota-dosen-d3");
    else if (prodi === "d4")
        table = $("#tabel-kuota-dosen-d4");

    table.find("tbody tr").remove();
}

function updateKuotaDosen(inputElements, prodi, nidn) {
    const data = {
        _token: $("meta[name='csrf-token']").attr('content'),
        kuota_pembimbing_1: inputElements[0].value,
        prodi: prodi,
        nidn: nidn
    };

    $.ajax({
        url: "/panitia/kuota-dosen/update",
        method: "PUT",
        data: data,
        dataType: "json",
        success: function (response) {
            const message = response.message;

            // Menampilkan pop up sukses
            $("#modal-popup-sukses .modal-body").text(message);
            $("#modal-popup-sukses").modal();

            // Memuat ulang halaman Kuota Dosen ketika Modal Popup di sembunyikan
            $("#modal-popup-sukses").on("hidden.bs.modal", function () {
                showAllDosen();
            });
        },
        error: function (jqXHR, status, error) {
            const errorMessage = jqXHR.responseJSON.message;

            // Menutup Modal Ubah Foto Profil
            $("#modal-ubah-foto-profil").modal('hide');

            // Menampilkan pop up error
            $("#modal-popup-error .modal-body").text(errorMessage);
            $("#modal-popup-error").modal();
        }
    });
}

function editItem(button, prodi) {
    const row = button.closest('tr');  // Ambil baris yang mengandung tombol
    const valueCells = row.querySelectorAll('td:nth-child(3), td:nth-child(4), td:nth-child(5)');  // Ambil sel dengan angka
    const inputElements = row.querySelectorAll('.value-edit');  // Ambil input untuk angka
    const spanElements = row.querySelectorAll('.value');  // Ambil span yang menampilkan angka

    // Jika tombol dalam keadaan "Edit", ubah ke mode edit
    if (button.classList.contains('btn-success')) {
        inputElements.forEach((input, index) => {
            input.style.display = 'inline';  // Tampilkan input
            spanElements[index].style.display = 'none';  // Sembunyikan nilai yang sedang ditampilkan
        });

        // Ubah tombol menjadi tombol simpan
        button.classList.remove('btn-success');
        button.classList.add('btn-primary');
        button.innerHTML = '<i class="fas fa-save"></i> Simpan';
    } else {
        // Jika tombol dalam keadaan "Simpan", simpan perubahan dan kembali ke mode edit
        inputElements.forEach((input, index) => {
            spanElements[index].innerHTML = input.value;  // Simpan nilai yang diubah
            input.style.display = 'none';  // Sembunyikan input
            spanElements[index].style.display = 'inline';  // Tampilkan angka yang baru
        });

        const nidn = row.querySelector("#nidn").value;

        // Mengupdate kuota Dosen
        updateKuotaDosen(inputElements, prodi, nidn);

        // Kembali ke tombol edit
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        button.innerHTML = '<i class="fas fa-edit"></i> Edit';
    }
}