<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.2;
            background-color: #f5f5f5;
            padding: 20px;
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

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .company-info {
            flex: 1;
            font-size: 12px;
            line-height: 1.3;
        }

        .company-info h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #000;
        }

        .card-title {
            flex: 0 0 200px;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
            background-color: #f0f0f0;
        }

        .card-title h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-title .doc-number {
            font-size: 12px;
            font-weight: bold;
        }

        .recipient-info {
            flex: 1;
            font-size: 12px;
            line-height: 1.4;
        }

        .recipient-info strong {
            font-weight: bold;
        }

        .nomor-surat {
            margin: 15px 0;
            padding: 8px;
            border: 1px solid #000;
            background-color: #f9f9f9;
            text-align: center;
        }

        .nomor-surat strong {
            font-weight: bold;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 12px;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
            padding: 6px 4px;
            border: 1px solid #000;
            text-align: center;
            font-size: 12px;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            vertical-align: middle;
        }

        td:first-child {
            text-align: center;
            width: 40px;
        }

        td:nth-child(2) {
            width: 80px;
            text-align: center;
        }

        td:nth-child(4) {
            text-align: center;
            font-size: 11px;
        }

        td:last-child {
            text-align: center;
            width: 80px;
        }

        .summary-row {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .note {
            font-size: 11px;
            margin: 15px 0;
            padding: 8px 0;
            border-bottom: 1px solid #000;
            text-align: left;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
            font-size: 12px;
        }

        .signature-box .title {
            margin-bottom: 40px;
            font-weight: bold;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 120px;
            margin: 0 auto;
        }

        .meta-info {
            font-size: 10px;
            color: #666;
            text-align: right;
            margin-top: 10px;
        }

        /* Responsive adjustments */
        @media print {
            body {
                padding: 0;
                background-color: white;
            }

            .detail-content {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="detail-content">
        <div class="card-header">
            <div class="company-info">
                <h3><?php echo isset($setting['nama_perusahaan']) ? $setting['nama_perusahaan'] : 'NAMA PERUSAHAAN' ?></h3>
                <?php echo isset($setting['alamat']) ? $setting['alamat'] : 'Alamat Perusahaan' ?><br />
                <?php if (isset($setting['telepon']) && !empty($setting['telepon'])): ?>
                    Telp: <?php echo $setting['telepon'] ?><br />
                <?php endif ?>
            </div>
            <div class="card-title">
                <h2>TANDA TERIMA</h2>
                <div class="doc-number"><?= $no_surat ?></div>
            </div>
            <div class="recipient-info">
                <strong>Tanggal:</strong> <?= $generated_date ?><br />
                <strong>Kepada:</strong> <?= $nama_pelanggan ?><br />
                <?php if (!empty($alamat_pelanggan)): ?>
                    <strong>Alamat:</strong> <?= $alamat_pelanggan ?>
                <?php endif ?>
            </div>
        </div>

        <div class="nomor-surat">
            <strong>Nomor Surat: <?= $no_surat ?></strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>JUMLAH</th>
                    <th>TANGGAL</th>
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
                        <td><?= $row['kode_barang'] ?></td>
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
            <strong>Catatan:</strong><br>
            • Pastikan barang yang diterima sudah sesuai dengan daftar di atas<br>
            • Batas waktu koreksi s.d tanggal: <?= date('d/m/Y', strtotime('+7 days')) ?><br>
            • Hubungi kami jika ada ketidaksesuaian
        </div>

        <div class="card-footer">
            <div class="signature-box">
                <div class="title">Diterima oleh,</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <div class="title">Diserahkan oleh,</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <div class="title">Disiapkan oleh,</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <div class="title">Disetujui oleh,</div>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="meta-info">
            Dicetak pada: <?= $generated_date ?> | Total Item: <?= isset($total_items) ? $total_items : count($data) ?>
        </div>
    </div>
</body>

</html>