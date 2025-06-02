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
                                                    <th>Total Harga</th>
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
                                                        <td><?= number_format($bk['harga'] * $bk['jumlah_keluar'], 0, ',', '.') ?></td>
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
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="text-center">Total</th>
                                                    <th class="text-right"><?= array_sum(array_column($transaksi, 'jumlah_keluar')) ?></th>
                                                    <th colspan="1"></th>
                                                    <th class="text-right"><?= number_format(array_sum(array_column($transaksi, 'harga')), 0, ',', '.') ?></th>
                                                    <th class="text-right"><?= number_format(array_sum(array_map(function ($item) {
                                                                                return $item['harga'] * $item['jumlah_keluar'];
                                                                            }, $transaksi)), 0, ',', '.') ?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
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

<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="add">
    <form role="form" id="myform" method="post" action="<?= site_url('pelanggan/trx') ?>">
        <?php if (isset($user)) : ?>
            <input type="hidden" id="id_user" value="<?= $user['id']; ?>">
        <?php endif ?>
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
                                <select name="pelanggan_id" id="pelanggan_id" class="select2-pelanggan form-select">
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
                                <select name="barang_id" id="barang_id" class="select2-barang form-select">
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
    </form>
</div>

<!-- Modal Unduh Surat -->
<div class="modal fade" tabindex="-1" id="unduh-surat">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unduh Surat Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Radio buttons untuk pilihan download -->
                <div class="form-group mb-4">
                    <label class="form-label">Pilih Metode Download <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="download_method" id="method_no_surat" value="no_surat" checked>
                                <label class="form-check-label" for="method_no_surat">
                                    <strong>Berdasarkan No. Surat</strong><br>
                                    <small class="text-muted">Download satu nomor surat tertentu</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="download_method" id="method_tanggal" value="tanggal">
                                <label class="form-check-label" for="method_tanggal">
                                    <strong>Berdasarkan Rentang Tanggal</strong><br>
                                    <small class="text-muted">Download per nomor surat dalam rentang tanggal</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form untuk No Surat -->
                <div id="form_no_surat" class="download-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-control-wrap">
                                    <label class="form-label" for="no_surat_select">No Surat <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="no_surat" id="no_surat_select" class="form-select">
                                            <option selected disabled value="">Pilih No Surat</option>
                                            <?php foreach ($surat as $s): ?>
                                                <option value="<?= $s['no_surat'] ?>"><?= $s['no_surat'] . ' | ' . $s['tanggal_keluar'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-text text-muted">Pilih nomor surat yang ingin diunduh</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info text untuk no surat -->
                    <div class="alert alert-info">
                        <strong>Informasi:</strong><br>
                        • Pilih nomor surat untuk mengunduh semua data terkait nomor surat tersebut<br>
                        • File akan diunduh dalam format PDF<br>
                        • Semua item dalam satu nomor surat akan menjadi satu dokumen PDF
                    </div>
                </div>

                <!-- Form untuk Rentang Tanggal -->
                <div id="form_tanggal" class="download-form" style="display: none;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-control-wrap">
                                    <label class="form-label" for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-control-wrap">
                                    <label class="form-label" for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info text untuk tanggal -->
                    <div class="alert alert-info">
                        <strong>Informasi:</strong><br>
                        • Pilih rentang tanggal untuk mengunduh semua surat dalam periode tersebut<br>
                        • Setiap nomor surat akan menjadi halaman/dokumen terpisah dalam satu file PDF<br>
                        • File akan diunduh dalam format PDF<br>
                        • Dokumen akan diurutkan berdasarkan tanggal dan nomor surat
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
                <button class="btn btn-primary" id="downloadBtn" disabled>
                    <span class="spinner-border spinner-border-sm me-2" role="status" style="display: none;"></span>
                    Unduh PDF
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- JS unduh surat -->
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#no_surat_select').select2({
            placeholder: "Pilih No Surat",
            allowClear: true,
            dropdownParent: $('#unduh-surat')
        });

        // Handle radio button change
        $('input[name="download_method"]').on('change', function() {
            const method = $(this).val();

            // Hide all forms
            $('.download-form').hide();

            // Show selected form
            if (method === 'no_surat') {
                $('#form_no_surat').show();
            } else if (method === 'tanggal') {
                $('#form_tanggal').show();
            }

            // Reset form validation
            validateForm();
        });

        // Validate form inputs
        function validateForm() {
            const method = $('input[name="download_method"]:checked').val();
            const downloadBtn = $('#downloadBtn');
            let isValid = false;

            if (method === 'no_surat') {
                isValid = $('#no_surat_select').val() !== null && $('#no_surat_select').val() !== '';
            } else if (method === 'tanggal') {
                const tanggalMulai = $('#tanggal_mulai').val();
                const tanggalSelesai = $('#tanggal_selesai').val();
                isValid = tanggalMulai !== '' && tanggalSelesai !== '' && tanggalMulai <= tanggalSelesai;
            }

            downloadBtn.prop('disabled', !isValid);
        }

        // Enable/disable download button based on selection
        $('#no_surat_select').on('change', validateForm);
        $('#tanggal_mulai, #tanggal_selesai').on('change', validateForm);

        // Validate date range
        $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
            const tanggalMulai = $('#tanggal_mulai').val();
            const tanggalSelesai = $('#tanggal_selesai').val();

            if (tanggalMulai && tanggalSelesai && tanggalMulai > tanggalSelesai) {
                showAlert('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai!');
                $('#tanggal_selesai').val('');
            }

            validateForm();
        });

        function resetForm() {
            $('input[name="download_method"][value="no_surat"]').prop('checked', true).trigger('change');
            $('#no_surat_select').val('').trigger('change');
            $('#tanggal_mulai, #tanggal_selesai').val('');
            $('#alertContainer').empty();
            showProgress(false);
        }

        function clearForm() {
            resetForm();
            $('#downloadBtn').prop('disabled', true);
        }

        // Handle download button click
        $('#downloadBtn').on('click', function() {
            const method = $('input[name="download_method"]:checked').val();
            let requestData = {
                method: method
            };

            // Validate based on method
            if (method === 'no_surat') {
                const no_surat = $('#no_surat_select').val();
                if (!no_surat) {
                    showAlert('error', 'Silakan pilih nomor surat terlebih dahulu!');
                    return;
                }
                requestData.no_surat = no_surat;
            } else if (method === 'tanggal') {
                const tanggalMulai = $('#tanggal_mulai').val();
                const tanggalSelesai = $('#tanggal_selesai').val();

                if (!tanggalMulai || !tanggalSelesai) {
                    showAlert('error', 'Silakan pilih rentang tanggal terlebih dahulu!');
                    return;
                }

                if (tanggalMulai > tanggalSelesai) {
                    showAlert('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai!');
                    return;
                }

                requestData.tanggal_mulai = tanggalMulai;
                requestData.tanggal_selesai = tanggalSelesai;
            }

            // Show progress
            showProgress(true);

            // AJAX request to download
            $.ajax({
                url: baseUrl + 'keluar/unduhSurat',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    showProgress(false);

                    if (response.success) {
                        showAlert('success', response.message);

                        // Create download link and trigger click
                        const downloadLink = document.createElement('a');
                        downloadLink.href = response.download_url;
                        downloadLink.download = response.filename;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    } else {
                        showAlert('error', response.message || 'Terjadi kesalahan saat mengunduh file');
                    }
                },
                error: function(xhr, status, error) {
                    showProgress(false);
                    console.error('AJAX Error:', error);
                    showAlert('error', 'Terjadi kesalahan koneksi. Silakan coba lagi.');
                }
            });
        });

        // Reset modal when closed
        $('#unduh-surat').on('hidden.bs.modal', function() {
            clearForm();
        });

        function showProgress(show) {
            const progressDiv = $('#downloadProgress');
            const downloadBtn = $('#downloadBtn');
            const spinner = downloadBtn.find('.spinner-border');

            if (show) {
                progressDiv.show();
                downloadBtn.prop('disabled', true);
                spinner.show();
            } else {
                progressDiv.hide();
                validateForm();
                spinner.hide();
            }
        }

        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';

            const alert = `
                <div class="alert ${alertClass} alert-dismissible fade show">
                    <strong>${type === 'success' ? 'Berhasil!' : 'Error!'}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            $('#alertContainer').html(alert);

            // Auto hide success alerts
            if (type === 'success') {
                setTimeout(function() {
                    $('#alertContainer .alert').alert('close');
                    clearForm();
                }, 2000);
            }
        }
    });
</script>

<!-- js add -->
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2-pelanggan').select2({
            placeholder: "Pilih Pelanggan",
            allowClear: true,
            dropdownParent: $('#add')
        });

        $('.select2-barang').select2({
            placeholder: "Pilih Barang",
            allowClear: true,
            dropdownParent: $('#add')
        });

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