$(document).ready(function() {
    let scanner = new Instascan.Scanner({ 
        video: document.getElementById('scanner'),
        backgroundScan: false,
        mirror: true
    });
    let barangIdSelect = document.getElementById('barang_id');

    scanner.addListener('scan', function (content) {
    const option = Array.from(barangIdSelect.options).find(option => option.value === content);

    if (option) {
        $('select[name="barang_id"]').val(content).change();
    } else {
        console.warn('Kode Barang ' + content + ' Tidak Ditemukan');
    }
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        let selectedCameraIndex = cameras.findIndex(camera => camera && camera.name.toLowerCase().includes('back'));

        if (selectedCameraIndex === -1 && cameras.length > 0) {
            // Jika kamera belakang tidak ditemukan, gunakan kamera pertama yang ditemukan
            selectedCameraIndex = 0;
        }

        if (cameras[selectedCameraIndex]) {
            scanner.start(cameras[selectedCameraIndex]);
            
            if (document.querySelector('input[name="options"]')) {
                document.querySelectorAll('input[name="options"]').forEach((element) => {
                    element.addEventListener("change", function (event) {
                        const item = event.target.value;
                        if (item == 1 || item == 2) {
                            if (cameras[item - 1]) {
                                scanner.start(cameras[item - 1]);
                            } else {
                                alert('Selected camera not available!');
                            }
                        } else {
                            alert('Invalid camera selection!');
                        }
                    });
                });                
            }
        } else {
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function(e) {
        console.warn(`${e}`);
    });
});
