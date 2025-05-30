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
                    </div><!-- .nk-block-head -->

                    <?= $this->session->flashdata('message'); ?>

                    <div class="nk-block nk-block-lg">
                        <div class="row g-gs">
                            <div class="col-lg-6">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-head">
                                            <h5 class="card-title">Setting Form</h5>
                                        </div>
                                        <?php echo form_open_multipart('setting'); ?>
                                        <input type="hidden" name="id" value="<?= $setting['id'] ?>">
                                        <div class="row gy-4">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="nama_aplikasi">Nama Aplikasi</label>
                                                    <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="<?= $setting['nama_aplikasi'] ?>">
                                                    <?= form_error('nama_aplikasi', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="nama_perusahaan">Nama Perusahaan</label>
                                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?= $setting['nama_perusahaan'] ?>">
                                                    <?= form_error('nama_perusahaan', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Email address</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?= $setting['email'] ?>">
                                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="notelpon">No Telphone</label>
                                                    <input type="number" class="form-control" id="notelpon" name="notelpon" value="<?= $setting['notelpon'] ?>">
                                                    <?= form_error('notelpon', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="notelpon">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $setting['alamat'] ?>">
                                                    <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="notelpon">Low Stok</label>
                                                    <input type="text" class="form-control" id="low_stok" name="low_stok" value="<?= $setting['low_stok'] ?>">
                                                    <?= form_error('low_stok', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="customFileLabel">Upload Logo</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" class="form-file-input" id="image" name="image">
                                                        <label class="form-file-label" for="customFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->