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
                                    <p>Laporan <?= $title; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Ikhtisar Penjualan</h6>
                                                            <p>Dalam 1 bulan penjualan langganan produk.</p>
                                                        </div>
                                                        <div class="card-tools">
                                                            <form action="<?= site_url('pelanggan/sales/' . encode_php_tags($pelanggan['id_pelanggan'])) ?>" method="post" class="form-inline" id="filterForm">
                                                                <div class="form-group mb-0">
                                                                    <div id="reportrange">
                                                                        <em class="icon ni ni-caret-down-fill"></em>&nbsp;
                                                                        <span></span> <em class="icon ni ni-calendar-alt"></em>
                                                                    </div>
                                                                    <input type="hidden" id="selectedStartDate" name="start_date">
                                                                    <input type="hidden" id="selectedEndDate" name="end_date">
                                                                    <input type="hidden" id="id_pelanggan" value="<?= $pelanggan['id_pelanggan'] ?>">
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="nk-block-head-content">
                                                                        <ul class="nk-block-tools g-3">
                                                                            <li>
                                                                                <button type="button" class="btn btn-icon btn-warning" onclick="resetDates()"><em class="icon ni ni-reload-alt"></em> Reset </button>
                                                                            </li>
                                                                            <li>
                                                                                <a onclick="generateCetak()" class="btn btn-icon btn-light"><em class="icon ni ni-printer"></em> Print</a>
                                                                            </li>
                                                                            <li>
                                                                                <butto onclick="generatePDF()" class="btn btn-icon btn-danger"><em class="icon ni ni-file-pdf"></em> PDF</butto>
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
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount"><?= $pelanggan['kode_toko'] ?></span>
                                                        </div>
                                                        <div class="nk-sale-data">
                                                            <span class="amount sm"><?= $total_trx; ?> <small>Transaksi</small></span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sales-ck large pt-4">
                                                        <canvas class="sales-overview-chart" id="salesOverview"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div>
                                    </div>
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
                            <table class="datatable-init nowrap table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sales as $item) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $item['id_bkeluar']; ?></td>
                                            <td><?= $item['nama_barang']; ?></td>
                                            <td><?= $item['nama_jenis']; ?></td>
                                            <td><?= (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0; ?></td>
                                            <td><?= tanggal($item['tanggal_keluar']) ?></td>
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
<script>
    var start_date_range = '<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>';
    var end_date_range = '<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>';
</script>
<script src="<?= base_url('assets') ?>/js/charts/sales.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/sales.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>