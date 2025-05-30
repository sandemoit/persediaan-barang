<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Cetak</title>
    <!-- Tambahkan CSS atau inline styles yang dibutuhkan untuk tampilan cetak -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;"><?= $title; ?></h2>
    <p style="text-align: center;">Periode: <?= $start_date . ' - ' . $end_date ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pelanggan)) : ?>
                <tr class="text-center bg-red">
                    <td colspan="7">Data tidak ditemukan!</td>
                </tr>
            <?php endif ?>
            <?php $no = 1; ?>
            <?php foreach ($pelanggan as $item) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['id_bkeluar']; ?></td>
                    <td><?= $item['nama_barang']; ?></td>
                    <td><?= $item['nama_jenis']; ?></td>
                    <td><?= (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0; ?></td>
                    <td><?= tanggal($item['tanggal_keluar']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <!-- Tambahkan tombol cetak otomatis menggunakan JavaScript -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>