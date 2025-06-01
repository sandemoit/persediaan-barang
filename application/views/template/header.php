<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="<?= base_url('assets') ?>/">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/') ?>favicon.png">
    <!-- Page Title  -->
    <title><?= $title; ?> - <?= setting('nama_aplikasi'); ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets') ?>/css/theme.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets') ?>/css/custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/bundle.js?ver=3.0.3"></script>

    <script>
        const baseurl = '<?= base_url() ?>';
        const segment = '<?= $this->uri->segment(1); ?>';
    </script>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">