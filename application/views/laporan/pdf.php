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
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Nama Supplier</th>
                <th>Stok Awal</th>
                <th>Jumlah Masuk</th>
                <th>Jumlah Keluar</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($laporan as $item) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['kode_barang']; ?></td>
                    <td><?= $item['nama_barang']; ?></td>
                    <td><?= $item['nama_supplier']; ?></td>
                    <td><?= $item['stok_awal']; ?></td>
                    <td><?= (!empty($item['jumlah_masuk'])) ? $item['jumlah_masuk'] : 0; ?></td>
                    <td><?= (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0; ?></td>
                    <td>
                        <?php
                        $totalStok = ((!empty($item['stok'])) ? $item['stok'] : 0);
                        echo $totalStok;
                        ?>
                    </td>
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