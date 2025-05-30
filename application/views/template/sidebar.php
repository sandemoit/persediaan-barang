<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
        <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-menu-trigger">
                    <a href="javascript:;" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    <a href="javascript:;" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
                <div class="nk-sidebar-brand">
                    <a href="html/index.html" class="logo-link nk-sidebar-logo">
                        <img class="logo-light logo-img" src="<?= base_url('assets/images/') . setting('image') ?>" srcset="<?= base_url('assets/images/') . setting('image') ?>" alt="logo">
                    </a>
                </div>
            </div><!-- .nk-sidebar-element -->
            <div class="nk-sidebar-element nk-sidebar-body">
                <div class="nk-sidebar-content">
                    <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu">
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Main Menu</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('dashboard') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                                    <span class="nk-menu-text">Dashboard</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <?php if (is_admin()) : ?>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url('usermanage') ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-account-setting-alt"></em></span>
                                        <span class="nk-menu-text">User Management</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                            <?php endif; ?>

                            <li class="nk-menu-item">
                                <a href="<?= site_url('setting') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                    <span class="nk-menu-text">Setting Aplikasi</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Data Master</h6>
                            </li><!-- .nk-menu-heading -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('pelanggan') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                    <span class="nk-menu-text">Pelanggan</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('supplier') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                    <span class="nk-menu-text">Supplier</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item has-sub">
                                <a href="javascript:;" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-folders"></em></em></span>
                                    <span class="nk-menu-text">Master Barang</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('satuan') ?>" class="nk-menu-link"><span class="nk-menu-text">Satuan Barang</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('jenis') ?>" class="nk-menu-link"><span class="nk-menu-text">Jenis Barang</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('barang') ?>" class="nk-menu-link"><span class="nk-menu-text">Data Barang</span></a>
                                    </li>
                                </ul><!-- .nk-menu-sub -->
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Transaksi</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('masuk') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-inbox-in-fill"></em></span>
                                    <span class="nk-menu-text">Barang Masuk</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <!-- <li class="nk-menu-item">
                                <a href="<?= site_url('keluar') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-inbox-out-fill"></em></span>
                                    <span class="nk-menu-text">Barang Keluar</span>
                                </a>
                            </li> -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('pelanggan/trx') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-inbox-out-fill"></em></span>
                                    <span class="nk-menu-text">Barang Keluar</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Lainnya</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('laporan') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-printer-fill"></em></span>
                                    <span class="nk-menu-text">Laporan Transaksi</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('database') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-server"></em></span>
                                    <span class="nk-menu-text">Back Up Database</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu -->
                    </div><!-- .nk-sidebar-menu -->
                </div><!-- .nk-sidebar-content -->
            </div><!-- .nk-sidebar-element -->
        </div>
        <!-- sidebar @e -->