<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @page {
            margin: 15mm;
            size: A5 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            line-height: 1.3;
            color: #000;
        }

        .detail-content {
            background: white;
            border: 2px solid #000;
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        /* Header menggunakan table untuk kompatibilitas DomPDF */
        .card-header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .card-header-table td {
            border: none;
            padding: 5px;
            vertical-align: top;
        }

        .company-info {
            width: 35%;
            font-size: 11px;
        }

        .company-info h3 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .card-title {
            width: 30%;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
            background-color: #f0f0f0;
        }

        .card-title h2 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .card-title .doc-number {
            font-size: 11px;
            font-weight: bold;
        }

        .recipient-info {
            width: 35%;
            font-size: 11px;
        }

        .recipient-info strong {
            font-weight: bold;
        }

        .nomor-surat {
            margin: 12px 0;
            padding: 8px;
            border: 1px solid #000;
            background-color: #f9f9f9;
            text-align: center;
        }

        .nomor-surat strong {
            font-weight: bold;
            font-size: 12px;
        }

        /* Table styling untuk data barang */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 8px;
        }

        .data-table th {
            background-color: #e0e0e0;
            font-weight: bold;
            padding: 8px 4px;
            border: 1px solid #000;
            text-align: center;
            font-size: 8px;
        }

        .data-table td {
            border: 1px solid #000;
            padding: 4px 4px;
            text-align: left;
            vertical-align: middle;
        }

        .data-table .text-center {
            text-align: center;
        }

        .data-table .no-col {
            width: 8%;
            text-align: center;
        }

        .data-table .kode-col {
            width: 18%;
            text-align: center;
        }

        .data-table .nama-col {
            width: 40%;
        }

        .data-table .jumlah-col {
            width: 17%;
            text-align: center;
        }

        .data-table .tanggal-col {
            width: 17%;
            text-align: center;
        }

        .summary-row {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .note {
            font-size: 8px;
            border-bottom: 1px solid #000;
            text-align: left;
        }

        /* Footer signatures menggunakan table */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .signature-table td {
            border: none;
            padding: 5px;
            text-align: center;
            width: 25%;
            font-size: 8px;
            vertical-align: top;
        }

        .signature-title {
            margin-bottom: 55px;
            font-weight: bold;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 80px;
            margin: 0 auto;
            height: 1px;
        }

        .meta-info {
            font-size: 9px;
            color: #333;
            text-align: right;
            margin-top: 8px;
        }

        /* Specific fixes untuk DomPDF */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="detail-content">
        <!-- Header menggunakan table untuk kompatibilitas -->
        <table class="card-header-table">
            <tr>
                <td class="company-info">
                    <h3><?php echo isset($setting['nama_perusahaan']) ? $setting['nama_perusahaan'] : 'NAMA PERUSAHAAN' ?></h3>
                    <?php echo isset($setting['alamat']) ? $setting['alamat'] : 'Alamat Perusahaan' ?><br />
                    <?php if (isset($setting['telepon']) && !empty($setting['telepon'])): ?>
                        Telp: <?php echo $setting['telepon'] ?><br />
                    <?php endif ?>
                </td>
                <td class="card-title">
                    <h2>TANDA TERIMA</h2>
                    <div class="doc-number"><?= $no_surat ?></div>
                </td>
                <td class="recipient-info">
                    <strong>Tanggal:</strong> <?= $generated_date ?><br />
                    <strong>Kepada:</strong> <?= $nama_pelanggan ?><br />
                    <strong>Area:</strong> <?= $area ?><br />
                    <?php if (!empty($alamat_pelanggan)): ?>
                        <strong>Alamat:</strong> <?= $alamat_pelanggan ?>
                    <?php endif ?>
                </td>
            </tr>
        </table>

        <!-- <div class="nomor-surat">
            <strong>Nomor Surat: <?= $no_surat ?></strong>
        </div> -->

        <!-- Data table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th class="no-col">NO.</th>
                    <th class="kode-col">KODE BARANG</th>
                    <th class="nama-col">NAMA BARANG</th>
                    <th class="jumlah-col">JUMLAH</th>
                    <th class="tanggal-col">TANGGAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_barang = 0;
                foreach ($data as $row):
                    $total_barang += $row['jumlah_keluar'];
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $row['kode_barang'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td class="text-center">
                            <?= number_format($row['jumlah_keluar'], 0, ',', '.') ?>
                            <?= strtoupper($row['nama_satuan'] ?: 'PCS') ?>
                        </td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_keluar'])) ?></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Summary row -->
                <tr class="summary-row">
                    <td colspan="3" class="text-center"><strong>TOTAL</strong></td>
                    <td class="text-center"><strong><?= number_format($total_barang, 0, ',', '.') ?> Items</strong></td>
                    <td class="text-center">-</td>
                </tr>
            </tbody>
        </table>

        <div class="note">
            <strong>Catatan:</strong> Pastikan barang yang diterima sudah sesuai dengan daftar di atas, batas waktu koreksi s.d tanggal <?= date('d/m/Y', strtotime('+7 days')) ?>
        </div>

        <!-- Signature menggunakan table -->
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-title">Diterima oleh,</div>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <div class="signature-title">Diserahkan oleh,</div>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <div class="signature-title">Disiapkan oleh,</div>
                    <div class="signature-line"></div>
                </td>
                <td>
                    <div class="signature-title">Disetujui oleh,</div>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>

        <div class="meta-info">
            Dicetak pada: <?= $generated_date ?> | Total Item: <?= isset($total_items) ? $total_items : count($data) ?>
        </div>
    </div>
</body>

</html>