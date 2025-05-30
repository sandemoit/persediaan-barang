$(document).ready(function () {
    const barangIdSelect = document.getElementById('barang_id');

    function onScanSuccess(decodedText) {
        const option = Array.from(barangIdSelect.options).find(option => option.value === decodedText);

        if (option) {
            $('select[name="barang_id"]').val(decodedText).change();
        } else {
            console.warn('ID Barang ' + decodedText + ' Tidak Ditemukan');
        }
    }

    function onScanFailure(error) {
        console.warn(`Gagal melakukan scan QR Code. ${error}`);
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 },
        { facingMode: { exact: "environment"} },
        { rememberLastUsedCamera: true },
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    $('#html5-qrcode-button-camera-stop').on('click', function() {
        html5QrcodeScanner.stop().then((ignore) => {
            alert('Sukses Stop')
        }).catch((err) => {
            // Stop failed, handle it.
            alert('Failed Stop')
        });
    });
});