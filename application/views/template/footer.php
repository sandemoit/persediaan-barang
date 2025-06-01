            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; <?= date('Y') ?> <a href="<?= site_url('/') ?>" target="_blank"><?= setting('nama_aplikasi'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?= base_url('assets') ?>/js/scripts.js?ver=3.0.3"></script>
            <!-- Menggunakan versi di-host (CDN) -->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

            <script type="text/javascript">
                const baseUrl = '<?= base_url() ?>';

                window.setTimeout(function() {
                    $("[role='alert']").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            </script>

            </body>

            </html>