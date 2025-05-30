<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('assets/images') ?>/favicon.png">
    <!-- Page Title  -->
    <title>Login | <?= setting('nama_aplikasi'); ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets') ?>/css/theme.css?ver=3.0.3">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?= site_url('/') ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?= base_url('assets/images/') . $setting['image'] ?>" srcset="<?= base_url('assets/images/') . $setting['image'] ?> 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?= base_url('assets/images/') . $setting['image'] ?>" srcset="<?= base_url('assets/images/') . $setting['image'] ?> 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In <?= $setting['nama_perusahaan'] ?></h4>
                                        <div class="nk-block-des">
                                            <p>Access <?= setting('nama_aplikasi'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->session->flashdata('message') ?>
                                <form method="POST" action="<?php echo base_url('auth') ?>">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" value="admin@gmail.com" class="form-control form-control-lg" name="email" id="default-01" placeholder="Enter your email address">
                                        </div>
                                        <?= form_error('email', '<small class="text-danger" pl-3>', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" value="admin" class="form-control form-control-lg" name="password" id="password" placeholder="Enter your password">
                                        </div>
                                        <?= form_error('password', '<small class="text-danger" pl-3>', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form>
                                <!-- <div class="form-note-s2 text-center pt-4"> New on our platform? <a href="javascript:;">Create an account</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wrap @e -->
    </div>
    <!-- content @e -->
    </div>
    <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?= base_url('assets') ?>/js/bundle.js?ver=3.0.3"></script>
    <script src="<?= base_url('assets') ?>/js/scripts.js?ver=3.0.3"></script>
    <!-- select region modal -->

</body>

</html>