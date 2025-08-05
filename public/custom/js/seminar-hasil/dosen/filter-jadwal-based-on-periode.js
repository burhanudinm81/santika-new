document.addEventListener('DOMContentLoaded', function(){
    const dropDownPeriode = document.getElementById("periode");
    
    
    dropDownPeriode.addEventListener('change', function () {
        const periodeId = this.value;
        console.log(`Periode Berubah, id Periode: ${periodeId}`);

        const regex = /\/tahap\/(\d+)/;
        const currentUrl = window.location.href;
        const match = currentUrl.match(regex);
        const tahapId = match ? match[1] : 1;

        window.location = `/dosen/seminar-hasil/jadwal/tahap/${tahapId}/periode/${periodeId}`;
    });
});