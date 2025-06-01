<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?= $title; ?></h3>
                                <div class="nk-block-des text-soft">
                                    <p>Data <?= $title; ?></p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <div class="dropdown">
                                        <a href="#unduh-surat" data-bs-toggle="modal" class="btn btn-icon btn-warning"><em class="icon ni ni-file"></em> Unduh Surat </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <a href="<?= site_url('pelanggan') ?>" class="btn btn-icon btn-info"><em class="icon ni ni-plus"></em>Add Pelanggan</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <a href="#add" class="btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em>Add <?= $title; ?></a>
                                    </div>
                                </li>
                                <form action="<?= site_url('pelanggan/trx') ?>" method="GET" class="g-3">
                                    <li>
                                        <div class="dropdown">
                                            <select name="no_surat" id="no_surat" class="form-select">
                                                <option selected disabled>No Surat</option>
                                                <?php foreach ($surat as $s) : ?>
                                                    <option <?= (isset($_GET['no_surat']) && $_GET['no_surat'] == $s['no_surat']) ? 'selected' : '' ?> value="<?= $s['no_surat'] ?>"><?= $s['no_surat'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <select name="id_barang" id="id_barang" class="form-select">
                                                <option selected disabled>Pilih Barang</option>
                                                <?php foreach ($barang as $b) : ?>
                                                    <option <?= (isset($_GET['id_barang']) && $_GET['id_barang'] == $b['kode_barang']) ? 'selected' : '' ?> value="<?= $b['kode_barang'] ?>"><?= $b['kode_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <select name="kondisi_barang" class="form-select">
                                                <option selected disabled>Kondisi Barang</option>
                                                <option <?= (isset($_GET['kondisi_barang']) && $_GET['kondisi_barang'] == 'Baru') ? 'selected' : '' ?> value="Baru">Baru</option>
                                                <option <?= (isset($_GET['kondisi_barang']) && $_GET['kondisi_barang'] == 'Reject') ? 'selected' : '' ?> value="Reject">Reject</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button type="submit" class="btn btn-icon btn-warning"><em class="icon ni ni-filter"></em> Filter </button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button type="submit" value="unduhExcel" name="isDownloadExcel" class="btn btn-icon btn-success"><em class="icon ni ni-file-xls"></em> Unduh Excel </button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <button type="submit" value="unduhPDF" name="isDownloadPDF" class="btn btn-icon btn-danger"><em class="icon ni ni-file"></em> Unduh PDF </button>
                                        </div>
                                    </li>
                                </form>
                            </ul>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-head -->

                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap table">
                                            <thead>
                                                <tr>
                                                    <th>No. </th>
                                                    <th>No Transaksi</th>
                                                    <th>No Surat</th>
                                                    <th>Tanggal Keluar</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Pelanggan</th>
                                                    <th>Harga</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($transaksi as $bk) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $bk['id_bkeluar'] ?></td>
                                                        <td><?= $bk['no_surat'] ?></td>
                                                        <td><?= tanggal($bk['tanggal_keluar'])  ?></td>
                                                        <td><?= $bk['nama_barang'] ?></td>
                                                        <td><?= $bk['jumlah_keluar'] ?></td>
                                                        <td><?= $bk['nama'] ?></td>
                                                        <td><?= number_format($bk['harga'], 0, ',', '.') ?></td>
                                                        <td>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pelanggan/delete/') . $bk['id_bkeluar'] ?>" class="btn btn-sm btn-danger"><em class="icon ni ni-trash"></em>Delete</a>
                                                            </div>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a href="<?= base_url('keluar/detail/') . $bk['id_bkeluar'] ?>" class="btn btn-sm btn-info"><em class="icon ni ni-eye"></em>Detail</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .card-preview -->
                            </div> <!-- nk-block -->
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

<!-- Modal Unduh Surat -->
<div class="modal fade" tabindex="-1" id="unduh-surat">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Unduh Surat Keluar</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-control-wrap">
                                <label class="form-label" for="no_surat_select">No Surat</label>
                                <div class="input-group">
                                    <select name="no_surat" id="no_surat_select" class="form-select">
                                        <option selected disabled value="">Pilih No Surat</option>
                                        <?php foreach ($surat as $s): ?>
                                            <option value="<?= $s['no_surat'] ?>"><?= $s['no_surat'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-control-wrap">
                                <label class="form-label" for="tanggal_awal">Tanggal Awal</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-control-wrap">
                                <label class="form-label" for="tanggal_akhir">Tanggal Akhir</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info text -->
                    <div class="alert alert-info mt-3">
                        <strong>Cara Penggunaan:</strong><br>
                        • <strong>Berdasarkan No Surat + Tanggal Hari Ini:</strong> Pilih No Surat saja (tanggal akan otomatis hari ini)<br>
                        • <strong>Berdasarkan No Surat + Rentang Tanggal:</strong> Pilih No Surat dan isi kedua tanggal<br>
                    </div>
                </div>

                <!-- Progress indicator -->
                <div id="downloadProgress" class="mt-3" style="display: none;">
                    <div class="d-flex align-items-center">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        <span>Sedang memproses unduhan...</span>
                    </div>
                </div>

                <!-- Success/Error messages -->
                <div id="alertContainer" class="mt-3"></div>
            </div>
            <div class="modal-footer bg-light">
                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                    <li>
                        <button class="btn btn-primary" id="downloadBtn" disabled>Unduh</button>
                    </li>
                    <li>
                        <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content Code -->
<form role="form" id="myform" method="post" action="<?= site_url('pelanggan/trx') ?>">
    <?php if (isset($user)) : ?>
        <input type="hidden" id="id_user" value="<?= $user['id']; ?>">
    <?php endif ?>
    <div class="modal fade" tabindex="-1" id="add">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Add <?= $title; ?></h5>
                </div>
                <div class="modal-body">
                    <p>No. Surat Jalan: <?= $no_surat; ?></p>
                    <input type="hidden" id="no_surat_keluar" value="<?= $no_surat; ?>">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Pelanggan</label>
                                <select name="pelanggan_id" id="pelanggan_id" data-search="on" class="js-select2">
                                    <option selected disabled>Pilih Pelanggan</option>
                                    <?php foreach ($pelanggan as $value) : ?>
                                        <option value="<?= $value['id_pelanggan']; ?>"><?= $value['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Tanggal keluar</label>
                                <input type="date" value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" class="form-control" name="tanggal_keluar" id="tanggal_keluar" placeholder="Nama barang">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Barang</label>
                                <select name="barang_id" id="barang_id" data-search="on" class="js-select2">
                                    <option selected disabled>Pilih Barang</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option data-stok="<?= $b['stok']; ?>" value="<?= $b['kode_barang']; ?>"><?= $b['kode_barang'] . ' | ' . $b['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p><a href=" <?= site_url('barang') ?>">+ Add Barang</a></p>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="stok">Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="stok" class="form-control">
                                        </div>
                                    </div>
                                    <p id="stokWarning" class="text-warning"><i>Stok Hampir Habis!</i></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" for="jumlah_keluar">Jumlah Keluar</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="number" class="form-control" for="jumlah_keluar" name="jumlah_keluar" id="jumlah_keluar" value="1" min="1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="satuan">pcs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="total_stok">Sisa Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="total_stok" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addtoList" class="btn btn-sm btn-primary mt-4 mb-4"><em class="icon ni ni-plus-sm"></em> Tambah ke List</button>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h6>List Barang Keluar</h6>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Barang</td>
                                        <td>Jumlah</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody id="list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="scanner-container" class="d-none"><video id="scanner" class="scann__qr"></video></div>
                <div class="modal-footer bg-light">
                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                        <li>
                            <button class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                        </li>
                        <li>
                            <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                        </li>
                        <!-- <li>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="cameraScanner">
                                <label class="custom-control-label" for="cameraScanner">Camera Scanner</label>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- js unduh surat -->
<script>
    $(document).ready(function() {
        // Elements
        const $noSuratSelect = $('#no_surat_select');
        const $tanggalAwal = $('#tanggal_awal');
        const $tanggalAkhir = $('#tanggal_akhir');
        const $downloadBtn = $('#downloadBtn');
        const $downloadProgress = $('#downloadProgress');
        const $alertContainer = $('#alertContainer');

        // Set default dates to today
        const today = new Date().toISOString().split('T')[0];

        // Reset form when modal opens
        $('#unduh-surat').on('show.bs.modal', function() {
            resetForm();
        });

        // Handle input changes for validation
        $noSuratSelect.on('change', checkFormValidation);
        $tanggalAwal.on('change', checkFormValidation);
        $tanggalAkhir.on('change', checkFormValidation);

        // Handle download button click
        $downloadBtn.on('click', function() {
            const noSurat = $noSuratSelect.val();
            const tanggalAwal = $tanggalAwal.val();
            const tanggalAkhir = $tanggalAkhir.val();

            // Validate inputs
            if (!noSurat && (!tanggalAwal || !tanggalAkhir)) {
                showAlert('Pilih No Surat atau isi rentang tanggal untuk mengunduh.', 'warning');
                return;
            }

            // Validate date range if both dates are filled
            if (tanggalAwal && tanggalAkhir && new Date(tanggalAwal) > new Date(tanggalAkhir)) {
                showAlert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.', 'warning');
                return;
            }

            // Prepare request data
            let requestData = {};

            if (noSurat) {
                requestData.no_surat = noSurat;

                // If no dates provided, use today's date
                if (!tanggalAwal || !tanggalAkhir) {
                    requestData.tanggal_awal = today;
                    requestData.tanggal_akhir = today;
                    requestData.berdasarkan = 'surat_jalan_hari_ini';
                } else {
                    requestData.tanggal_awal = tanggalAwal;
                    requestData.tanggal_akhir = tanggalAkhir;
                    requestData.berdasarkan = 'surat_jalan_rentang';
                }
            } else {
                // Only date range
                requestData.tanggal_awal = tanggalAwal;
                requestData.tanggal_akhir = tanggalAkhir;
                requestData.berdasarkan = 'rentang_tanggal';
            }

            startDownload(requestData);
        });

        function checkFormValidation() {
            const noSurat = $noSuratSelect.val();
            const tanggalAwal = $tanggalAwal.val();
            const tanggalAkhir = $tanggalAkhir.val();

            // Enable button if:
            // 1. No Surat is selected (dates are optional)
            // 2. OR both dates are filled (No Surat is optional)
            const isValid = noSurat || (tanggalAwal && tanggalAkhir);

            $downloadBtn.prop('disabled', !isValid);
            clearAlerts();
        }

        function resetForm() {
            $noSuratSelect.val('');
            $tanggalAwal.val(today);
            $tanggalAkhir.val(today);
            $downloadBtn.prop('disabled', true);
            clearAlerts();
        }

        function startDownload(data) {
            $downloadBtn.prop('disabled', true);
            $downloadProgress.show();
            clearAlerts();

            $.ajax({
                url: '<?= base_url('keluar/unduhSurat') ?>',
                type: 'POST',
                data: data,
                dataType: 'json',
                timeout: 30000, // 30 seconds timeout
                success: function(response) {
                    $downloadProgress.hide();

                    if (response && response.success) {
                        if (response.download_url) {
                            // Create temporary link to download file
                            const link = document.createElement('a');
                            link.href = response.download_url;
                            link.download = response.filename || 'surat-keluar.pdf';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        showAlert(response.message + (response.file_size ? ' (Ukuran: ' + response.file_size + ')' : ''), 'success');
                        resetFormAfterDownload();
                    } else {
                        showAlert(response.message || 'Terjadi kesalahan saat mengunduh file.', 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error Details:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        statusCode: xhr.status
                    });

                    $downloadProgress.hide();

                    let errorMessage = 'Terjadi kesalahan pada server.';

                    if (xhr.responseText) {
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            if (errorResponse.message) {
                                errorMessage = errorResponse.message;
                            }
                        } catch (e) {
                            console.error('Failed to parse error response:', e);
                            errorMessage += ' Detail: ' + xhr.responseText.substring(0, 100);
                        }
                    }

                    showAlert(errorMessage, 'danger');
                },
                complete: function() {
                    checkFormValidation();
                }
            });
        }

        function resetFormAfterDownload() {
            $noSuratSelect.val('');
            // Keep today's date as default
            $tanggalAwal.val(today);
            $tanggalAkhir.val(today);
            checkFormValidation();
        }

        function showAlert(message, type) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $alertContainer.html(alertHtml);
        }

        function clearAlerts() {
            $alertContainer.empty();
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.js-select2').select2();

        var n = 1;
        var ls = [];

        $('#addtoList').click(function() {
            var plg = $("#pelanggan_id").val();
            var brg = $("#barang_id").val();
            var sel = $("#barang_id option:selected").text(); // Alternatif cara mendapatkan text
            var jum = parseInt($("#jumlah_keluar").val());
            var iduser = $("#id_user").val();
            var tgl = $("#tanggal_keluar").val();
            var nosurat = $('#no_surat_keluar').val();

            // Debugging - cek nilai yang didapat
            // console.log(nosurat);

            // Validasi input
            if (!plg) {
                alert('Isikan Pelanggan dengan benar.');
                return false;
            }

            if (!brg) {
                alert('Isikan Barang dengan benar.');
                return false;
            }

            if (!jum || jum <= 0) {
                alert('Isikan Jumlah dengan benar.');
                return false;
            }

            var ch = ls.includes(brg);

            $.post(baseurl + 'pelanggan/getstok/' + brg, function(res, status) {
                var stok = parseInt(res) || 0;

                if (ch) {
                    // Item sudah ada, update jumlah
                    var currentJum = parseInt($('#jls-' + brg).val()) || 0;
                    var newJum = currentJum + jum;

                    if (newJum > stok) {
                        alert('Maaf sisa stok tidak cukup : ' + stok);
                        return false;
                    } else {
                        $('#jls-' + brg).val(newJum);
                        $('#jtextls-' + brg).text(newJum);
                    }
                } else {
                    // Item baru
                    if (jum > stok) {
                        alert('Maaf sisa stok tidak cukup : ' + stok);
                        return false;
                    } else {
                        ls.push(brg);

                        var nr = `<tr id="trlist-${brg}">
                        <td>
                            <input type="hidden" name="tanggal_keluar[${n}]" id="tls-${n}" value="${tgl}">
                            <input type="hidden" name="id_user[${n}]" id="ils-${n}" value="${iduser}">
                            <input type="hidden" name="no_surat[${n}]" id="nls-${n}" value="${nosurat}">
                            <input type="hidden" name="pelanggan_id[${n}]" id="pls-${n}" value="${plg}">
                            <input type="hidden" name="barang_id[${n}]" id="bls-${n}" value="${brg}">
                            <input type="hidden" name="jumlah_keluar[${n}]" id="jls-${brg}" value="${jum}">
                            ${sel}
                        </td>
                        <td><span id="jtextls-${brg}">${jum}</span></td>
                        <td align="center">
                            <button type="button" onclick="removeList('${brg}')" class="btn btn-sm btn-danger">
                                <em class="icon ni ni-trash-alt"></em>
                            </button>
                        </td>
                    </tr>`;

                        $('#list').append(nr);
                        n++;
                    }
                }

                // Clear form inputs
                $('#jumlah_keluar').val('');
                $('#barang_id').val('').trigger('change');

            }).fail(function() {
                alert('Error getting stock data');
            });
        });

        function removeList(brg) {
            var brg = brg.toString();
            var posDel = $.inArray(brg, ls);

            if (posDel > -1) {
                ls.splice(posDel, 1);
            }

            $(`#trlist-${brg}`).remove();
        }

        // Make removeList globally accessible
        window.removeList = removeList;

        // Event handler untuk select barang - update stok display
        $('#barang_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var stok = selectedOption.data('stok') || 0;

            $('#stok').val(stok);

            // Hitung sisa stok berdasarkan jumlah keluar
            updateSisaStok();

            // Show/hide warning
            if (stok <= 5 && stok > 0) {
                $('#stokWarning').show();
            } else {
                $('#stokWarning').hide();
            }
        });

        // Event handler untuk jumlah keluar
        $('#jumlah_keluar').on('input', function() {
            updateSisaStok();
        });

        function updateSisaStok() {
            var stok = parseInt($('#stok').val()) || 0;
            var jumlahKeluar = parseInt($('#jumlah_keluar').val()) || 0;
            var sisaStok = stok - jumlahKeluar;

            $('#total_stok').val(sisaStok);

            // Validasi real-time
            if (sisaStok < 0) {
                $('#total_stok').addClass('is-invalid');
                $('#jumlah_keluar').addClass('is-invalid');
            } else {
                $('#total_stok').removeClass('is-invalid');
                $('#jumlah_keluar').removeClass('is-invalid');
            }
        }
    });
</script>

<script src="<?= base_url('assets') ?>/js/custom/barang-keluar.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/count-stok.js"></script>
<!-- <script src="<?= base_url('assets') ?>/js/custom/scanqr.js"></script> -->