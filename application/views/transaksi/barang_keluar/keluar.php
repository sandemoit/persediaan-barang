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
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="dropdown">
                                            <a href="#add" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em>Add <?= $title; ?></a>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
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
                                                    <th>Tanggal Keluar</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah Keluar</th>
                                                    <th>Petugas</th>
                                                    <th>Harga</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($barangkeluar as $bk) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $bk['id_bkeluar'] ?></td>
                                                        <td><?= tanggal($bk['tanggal_keluar'])  ?></td>
                                                        <td><?= $bk['nama_barang'] ?></td>
                                                        <td><?= $bk['jumlah_keluar'] ?></td>
                                                        <td><?= $bk['name'] ?></td>
                                                        <td><?= number_format($bk['harga'], 0, ',', '.') ?></td>
                                                        <td>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('keluar/delete/') . $bk['id_bkeluar'] ?>" class="btn btn-sm btn-danger"><em class="icon ni ni-trash"></em>Delete</a>
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


<!-- Add Room-->
<div class="modal fade" tabindex="-1" role="dialog" id="add">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Add <?= $title; ?></h5>
                <form action="<?= base_url('keluar') ?>" method="post">
                    <input type="hidden" value="<?= $user['id']; ?>" class="form-control" name="id_user">
                    <div class="row g-gs">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="room-no-add">No Transaksi</label>
                                        <input readonly type="text" value="<?= $id_bkeluar ?>" class="form-control" name="id_bkeluar">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="room-no-add">Tanggal keluar</label>
                                        <input type="date" value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" class="form-control" name="tanggal_keluar" id="tanggal_keluar" placeholder="Nama barang">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="room-no-add">Barang</label>
                                        <select name="barang_id" id="barang_id" data-search="on" class="form-select js-select2">
                                            <option selected disabled>Pilih Barang</option>
                                            <?php foreach ($barang as $b) : ?>
                                                <option data-stok="<?= $b['stok']; ?>" value="<?= $b['id_barang']; ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p><a href=" <?= site_url('barang') ?>">+ Add Barang</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="stok">Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="stok" class="form-control">
                                        </div>
                                    </div>
                                    <p id="stokWarning" class="text-warning"><i>Stok Hampir Habis!</i></p>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="jumlah_keluar">Jumlah Keluar</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="number" class="form-control" for="jumlah_keluar" name="jumlah_keluar" id="jumlah_keluar" placeholder="Jumlah Keluar">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="satuan">Satuan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="total_stok">Sisa Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="total_stok" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="room-no-add">Surat Jalan</label>
                                    <input type="file" value="<?= set_value('no_surat') ?>" class="form-control" name="no_surat" id="no_surat">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12" id="scanner-container">
                            <!-- disini camera reader qr code -->
                            <video id="scanner" class="scann__qr"></video>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                                </li>
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                                <li>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="cameraScanner">
                                        <label class="custom-control-label" for="cameraScanner">Camera Scanner</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<script src="<?= base_url('assets') ?>/js/custom/barang-keluar.js"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/scanqr.js"></script>