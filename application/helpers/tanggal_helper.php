<?php
if (!function_exists('tanggal')) {
    function tanggal($tanggal)
    {
        $ubahTanggal = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecahTanggal = explode('-', $ubahTanggal);
        $tanggal = $pecahTanggal[2];
        $bulan = $pecahTanggal[1];
        $tahun = $pecahTanggal[0];
        return $tanggal . ' ' . bulan_panjang($bulan) . ' ' . $tahun;
    }
}
if (!function_exists('tgl')) {
    function tgl($tanggal)
    {
        $ubahTanggal = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecahTanggal = explode('-', $ubahTanggal);
        $tanggal = $pecahTanggal[2];
        $bulan = bulan_panjang($pecahTanggal[1]);
        $tahun = $pecahTanggal[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}
if (!function_exists('bulan_panjang')) {
    function bulan_panjang($bulan)
    {
        switch ($bulan) {
            case 1:
                return 'Januari';
                break;
            case 2:
                return 'Februari';
                break;
            case 3:
                return 'Maret';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'Mei';
                break;
            case 6:
                return 'Juni';
                break;
            case 7:
                return 'Juli';
                break;
            case 8:
                return 'Agustus';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'Oktober';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'Desember';
                break;
        }
    }
}
