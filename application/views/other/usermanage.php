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
                                                    <th>No </th>
                                                    <th>Photo</th>
                                                    <th>Nama</th>
                                                    <th>User Dibuat</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($userm as $um) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td>
                                                            <div class="user-avatar">
                                                                <img src="<?= base_url('assets/images/avatar/') . $um['image'] ?>" alt="">
                                                            </div>
                                                        </td>
                                                        <td><?= $um['name']  ?></td>
                                                        <td><?= date('d-m-Y', $um['date_created'])  ?></td>
                                                        <td><?= $um['email']  ?></td>
                                                        <td><?= $um['role']  ?></td>
                                                        <td>
                                                            <?php if ($um['is_active']) : ?>
                                                                <span class="tb-status text-success">Active</span>
                                                            <?php else : ?>
                                                                <span class="tb-status text-danger">Deactive</span>
                                                            <?php endif ?>
                                                        </td>
                                                        <td>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a onclick="return confirm('Yakin ingin aktif/nonaktifkan?')" href="<?= base_url('usermanage/toggle/') . $um['id'] ?>" class="btn btn-sm btn-secondary"><em class="icon ni ni-user-cross-fill"></em>
                                                                </a>

                                                                <a href="#edit<?= $um['id'] ?>" class="btn btn-sm btn-warning" data-bs-toggle="modal"><em class="icon ni ni-pen"></em>
                                                                </a>

                                                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('usermanage/delete/') . $um['id'] ?>" class="btn btn-sm btn-danger"><em class="icon ni ni-trash"></em>
                                                                </a>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Add <?= $title; ?></h5>
                <?php echo form_open_multipart('usermanage'); ?>
                <div class="row g-gs">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email Login">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="gudang">Gudang</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Password</label>
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">konfirmasi Password</label>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="konfirmasi Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">Add Users</button>
                    </div>
                </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- Edit Room-->
<?php foreach ($userm as $um) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $um['id'] ?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Add <?= $title; ?></h5>
                    <form action="<?= site_url('usermanage/edit') ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $um['id'] ?>">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Email</label>
                                    <input type="text" disabled class="form-control" id="email" name="email" value="<?= $um['email'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Role</label>
                                    <select name="role" id="role" class="form-select js-select2 js-select2-sm">
                                        <option disabled>Select role</option>
                                        <option value="admin" <?php echo ($um['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="gudang" <?php echo ($um['role'] == 'gudang') ? 'selected' : ''; ?>>Gudang</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $um['name'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Password</label>
                                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                                    <p class="text-danger"><em>Kosongkan jika tidak ganti password</em></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password2" name="password2" placeholder="konfirmasi Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Edit User</button>
                            </div>
                        </div>
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
<?php endforeach; ?>