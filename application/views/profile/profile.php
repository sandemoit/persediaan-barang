<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head nk-block-head-lg">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Informasi pribadi</h4>
                                            <div class="nk-block-des">
                                                <p>Info dasar, seperti nama dan alamat Anda, yang Anda gunakan di PT Anda.</p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <?= $this->session->flashdata('message'); ?>
                                <div class="nk-block">
                                    <div class="nk-data data-list">
                                        <div class="data-head">
                                            <h6 class="overline-title">Basics</h6>
                                        </div>
                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Nama Lengkap</span>
                                                <span class="data-value"><?= $user['name'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div><!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Email</span>
                                                <span class="data-value"><?= $user['email'] ?></span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                        </div><!-- data-item -->
                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Phone Number</span>
                                                <?php if ($user['nohp'] == null) : ?>
                                                    <span class="data-value text-soft">Belum menambahkan</span>
                                                <?php else : ?>
                                                    <span class="data-value text-soft"><?= $user['nohp'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div><!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Role</span>
                                                <span class="data-value text-soft"><b><?= $user['role'] ?></b></span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                        </div><!-- data-item -->
                                        <!-- <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                            <div class="data-col">
                                                <span class="data-label">Address</span>
                                                <span class="data-value">2337 Kildeer Drive,<br>Kentucky, Canada</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div>data-item -->
                                    </div><!-- data-list -->
                                </div><!-- .nk-block -->
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                <img src="<?= base_url('assets/images/avatar/') . $user['image'] ?>" alt="">
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?= $user['name'] ?></span>
                                                <span class="sub-text"><?= $user['email'] ?></span>
                                            </div>
                                            <div class="user-action">
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a data-bs-toggle="modal" href="#photo"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                            <li><a data-bs-toggle="modal" data-bs-target="#profile-edit" href="javascript:;"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .user-card -->
                                    </div><!-- .card-inner -->
                                    <div class="card-inner p-0">
                                        <ul class="link-list-menu">
                                            <li><a class="active" href="javascript:;"><em class="icon ni ni-user-fill-c"></em><span>Informasi Pribadi</span></a></li>
                                            <!-- <li><a href="html/user-profile-notification.html"><em class="icon ni ni-bell-fill"></em><span>Notifications</span></a></li> -->
                                            <!-- <li><a href="javascript:;"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li> -->
                                            <li><a href="<?= site_url('profile/changepassword') ?>"><em class="icon ni ni-lock-alt-fill"></em><span>Pengaturan keamanan</span></a></li>
                                        </ul>
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div><!-- card-aside -->
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <button class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></button>
            <div class="modal-body modal-body-sm">
                <h5 class="title">Update Profile</h5>
                <ul class="nk-nav nav nav-tabs">
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <form action="<?= site_url('profile/edit') ?>" method="POST">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Email</label>
                                    <input readonly type="email" class="form-control form-control-lg" value="<?= $user['email'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="full-name">Role</label>
                                    <input readonly type="text" class="form-control form-control-lg" value="<?= $user['role'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="display-name">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="<?= $user['name'] ?>" placeholder="Enter Nama Lengkap">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="display-name">No HP</label>
                                    <input type="text" class="form-control form-control-lg" name="nohp" value="<?= $user['nohp'] ?>" placeholder="Enter No HP">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <button type="submit" class="btn btn-lg btn-primary">Update Profile</button>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" role="dialog" id="photo">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <button class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></button>
            <div class="modal-body modal-body-sm">
                <h5 class="title">Update Profile</h5>
                <ul class="nk-nav nav nav-tabs">
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <form action="<?= base_url('profile/image'); ?>" method="post" enctype="multipart/form-data" id="imageForm">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="image">Upload Foto</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" id="image" name="image" accept="image/jpeg,image/png" required>
                                            <label class="form-file-label" for="image">Choose foto</label>
                                            <p class="text-orange"><em>Maximal upload 2 MB & Format JPG, PNG.</em></p>
                                            <div id="imagePreview" class="mt-2">
                                                <?php if ($user['image'] != 'default.jpg'): ?>
                                                    <img src="<?= base_url('assets/images/avatar/' . $user['image']) ?>" alt="Current Profile" style="max-height: 100px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li>
                                        <button type="submit" class="btn btn-lg btn-primary">Update Photo</button>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                    </li>
                                </ul>
                            </div>
                        </form>

                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<script>
    // Client-side image preview and validation
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (!file) return;

        // Check file type
        if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
            alert('Hanya file JPG/JPEG atau PNG yang diperbolehkan.');
            e.target.value = '';
            return;
        }

        // Check file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB.');
            e.target.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-height: 100px;">';
        }
        reader.readAsDataURL(file);
    });
</script>