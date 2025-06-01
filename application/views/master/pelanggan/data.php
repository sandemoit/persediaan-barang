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
                                            <a href="#add" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em></a>
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
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Area</th>
                                                    <th>Alamat</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($pelanggan as $value) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><a href="<?= site_url('pelanggan/sales/' . $value['id_pelanggan']) ?>"><?= $value['nama'] ?> <em class="icon ni ni-cart"></em></a></td>
                                                        <td><?= $value['kode_toko'] ?></td>
                                                        <td><?= $value['alamat'] ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a data-bs-toggle="modal" href="#edit<?= $value['id_pelanggan'] ?>" class="text-primary"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                        <li><a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pelanggan/delete/') . $value['id_pelanggan'] ?>" class="text-danger"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                                                    </ul>
                                                                </div>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Tambah user</h5>
                <form action="<?= site_url('pelanggan') ?>" method="POST" class="mt-2">
                    <div class="row g-gs">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Kode Toko</label>
                                <input type="text" class="form-control" name="kode_toko" id="kode_toko" placeholder="TK123****">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Cth. Desa Payabakal">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Add user</button>
                                </li>
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<!-- Add Room-->
<?php foreach ($pelanggan as $value) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $value['id_pelanggan'] ?>">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit pelanggan</h5>
                    <form action="<?= site_url('pelanggan/edit/' . $value['id_pelanggan']) ?>" method="POST" class="mt-2">
                        <div class="row g-gs">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?= $value['nama'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Kode Toko</label>
                                    <input type="text" class="form-control" name="kode_toko" id="kode_toko" placeholder="TK123****" value="<?= $value['kode_toko'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Cth. Desa Payabakal" value="<?= $value['alamat'] ?>">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <button class="btn btn-primary" data-bs-dismiss="modal">Update satuan</button>
                                    </li>
                                    <li>
                                        <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
<?php endforeach; ?>