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
                                            <h4 class="nk-block-title">Pengaturan keamanan</h4>
                                            <div class="nk-block-des">
                                                <p>Pengaturan ini membantu Anda menjaga keamanan akun Anda.</p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <?php if (validation_errors()) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= validation_errors(); ?>
                                    </div>
                                <?php endif; ?>
                                <?= $this->session->flashdata('message'); ?>
                                <div class="nk-block">
                                    <div class="card card-bordered">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="between-center flex-wrap g-3">
                                                    <div class="nk-block-text">
                                                        <h6>Ganti Password</h6>
                                                        <p>Tetapkan kata sandi unik untuk melindungi akun Anda.</p>
                                                    </div>
                                                    <div class="nk-block-actions flex-shrink-sm-0">
                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                            <li class="order-md-last">
                                                                <a data-bs-toggle="modal" href="#password-edit" class="btn btn-primary">Change Password</a>
                                                            </li>
                                                            <li>
                                                                <em class="text-soft text-date fs-12px">Terakhir diubah: <span><?= date('M d, Y', $user['last_change_pw']) ?></span></em>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .card-inner -->
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
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
                                                            <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                            <li><a data-bs-toggle="modal" data-bs-target="#profile-edit" href="javascript:;"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .user-card -->
                                    </div><!-- .card-inner -->
                                    <div class="card-inner p-0">
                                        <ul class="link-list-menu">
                                            <li><a href="<?= site_url('profile') ?>"><em class="icon ni ni-user-fill-c"></em><span>Informasi Pribadi</span></a></li>
                                            <!-- <li><a href="html/user-profile-notification.html"><em class="icon ni ni-bell-fill"></em><span>Notifications</span></a></li> -->
                                            <li><a href="javascript:;"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                            <li><a class="active" href="<?= site_url('profile/changepassword') ?>"><em class="icon ni ni-lock-alt-fill"></em><span>Pengaturan keamanan</span></a></li>
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

<!-- edit password -->
<?php foreach ($user as $u) : ?>
    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" role="dialog" id="password-edit">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <button class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></button>
                <div class="modal-body modal-body-md">
                    <h5 class="title">Update Password</h5>
                    <ul class="nk-nav nav nav-tabs">
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="password">
                            <form action="<?= site_url('profile/changepassword') ?>" method="POST">
                                <div class="row gy-4">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Password Lama</label>
                                            <input type="password" class="form-control form-control-lg" id="password_lama" name="password_lama" placeholder="Password Lama">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Password Baru</label>
                                            <input type="password" class="form-control form-control-lg" id="baru_1" name="baru_1" placeholder="Password Baru">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">Konfrimasi Password</label>
                                            <input type="password" class="form-control form-control-lg" id="baru_2" name="baru_2" placeholder="Konfrimasi Password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button type="submit" class="btn btn-lg btn-primary">Change Password</button>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
<?php endforeach; ?>