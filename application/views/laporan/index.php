<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg ">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?= $title; ?></h3>
                                <div class="nk-block-des text-soft">
                                    <p>Data <?= $title; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>

                    <div class="card card-bordered card-preview col-12 ">
                        <div class="card-inner">
                            <div class="row form-group">
                                <label class="form-label">Filter Tanggal</label>
                                <form action="<?= site_url('laporan') ?>" method="post" class="form-inline" id="filterForm">
                                    <div class="form-group mb-0">
                                        <div id="reportrange">
                                            <em class="icon ni ni-caret-down-fill"></em>&nbsp;
                                            <span></span> <em class="icon ni ni-calendar-alt"></em>
                                        </div>
                                        <input type="hidden" id="selectedStartDate" name="start_date">
                                        <input type="hidden" id="selectedEndDate" name="end_date">
                                    </div>
                                    <div class="col-3">
                                        <div class="nk-block-head-content">
                                            <ul class="nk-block-tools g-3">
                                                <li>
                                                    <a class="btn btn-icon btn-warning" onclick="resetDates()"><em class="icon ni ni-reload-alt"></em> Reset </a>
                                                </li>
                                                <li>
                                                    <a onclick="generateCetak()" class="btn btn-icon btn-light"><em class="icon ni ni-printer"></em> Print</a>
                                                </li>
                                                <li>
                                                    <a onclick="generatePDF()" class="btn btn-icon btn-danger"><em class="icon ni ni-file-pdf"></em> PDF</a>
                                                </li>
                                                <li>
                                                    <a onclick="downloadExcel()" class="btn btn-icon btn-success"><em class="icon ni ni-file-xls"></em> Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-inner">
                            <table class="datatable-init nowrap table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah stok awal</th>
                                        <th>Jumlah Barang Masuk</th>
                                        <th>Jumlah Barang Keluar</th>
                                        <th>Hasil Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($laporan as $item) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $item['kode_barang']; ?></td>
                                            <td><?= $item['nama_barang']; ?></td>
                                            <td><?= $item['stok_awal']; ?></td>
                                            <td><?= (!empty($item['jumlah_masuk'])) ? $item['jumlah_masuk'] : 0; ?></td>
                                            <td><?= (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0; ?></td>
                                            <td><?= ((!empty($item['stok'])) ? $item['stok'] : 0); ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets') ?>/js/custom/laporan.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>