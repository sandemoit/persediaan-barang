document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen input stok
    var stokInput = document.getElementById('stok');

    // Ambil elemen warning
    var stokWarning = document.getElementById('stokWarning');

    // Tentukan nilai batas untuk menampilkan warning
    var batasStok = 10;

    // Fungsi untuk menangani perubahan nilai pada input stok
    function handleStokChange() {
        // Ambil nilai stok dari input
        var nilaiStok = parseInt(stokInput.value);

        // Periksa apakah nilai stok kurang dari batas
        if (!isNaN(nilaiStok) && nilaiStok < batasStok) {
            stokWarning.style.display = 'block';
        } else {
            stokWarning.style.display = 'none';
        }
    }

    // listener perubahan untuk mengambil perubahan nilai stok saat ini
    stokInput.addEventListener('input', handleStokChange);

    // Jalankan fungsi handleStokChange pertama kali untuk menampilkan warning jika diperlukan
    handleStokChange();
});

// Skrip yang menggunakan fungsi stopScanner()
// document.addEventListener('DOMContentLoaded', function() {
//     var scannerVideo = document.getElementById('scanner-container');
//     var cameraSwitch = document.getElementById('cameraScanner');

//     function toggleScannerVideo() {
//         if (cameraSwitch.checked) {
//             scannerVideo.style.display = 'block';
//         } else {
//             scannerVideo.style.display = 'none';
//         }
//     } 

//     toggleScannerVideo();
//     cameraSwitch.addEventListener('change', toggleScannerVideo);
// });