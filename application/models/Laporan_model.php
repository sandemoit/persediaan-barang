<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function getLaporan($jenis_laporan, $tanggal_awal, $tanggal_akhir)
    {
        if ($jenis_laporan == 'Barang Masuk') {
            $this->db->select('barang_masuk.*, u.*, b.*');
            $this->db->join('user u', 'barang_masuk.id_user = u.id');
            $this->db->join('barang b', 'barang_masuk.barang_id = b.kode_barang');
            $this->db->where('tanggal_masuk >=', $tanggal_awal);
            $this->db->where('tanggal_masuk <=', $tanggal_akhir);
            $this->db->order_by('tanggal_masuk', 'desc');
            $query = $this->db->get('barang_masuk');
            return $query->result();
        } elseif ($jenis_laporan == 'Barang Keluar') {
            $this->db->select('barang_keluar.*, u.*, b.*');
            $this->db->join('user u', 'barang_keluar.id_user = u.id');
            $this->db->join('barang b', 'barang_keluar.barang_id = b.kode_barang');
            $this->db->where('tanggal_keluar >=', $tanggal_awal);
            $this->db->where('tanggal_keluar <=', $tanggal_akhir);
            $this->db->order_by('tanggal_keluar', 'desc');
            $query = $this->db->get('barang_keluar');
            return $query->result();
        } else {
            // Jenis laporan tidak valid, return null atau berikan pesan error sesuai kebutuhan
            return null;
        }
    }

    public function getLaporanData($startDate = null, $endDate = null)
    {
        $this->db->select('barang.id_barang, nama_barang, stok_awal, stok, kode_barang');
        $this->db->select('IFNULL(SUM(jumlah_masuk), 0) AS jumlah_masuk', false);
        $this->db->select('IFNULL(SUM(jumlah_keluar), 0) AS jumlah_keluar', false);

        $this->db->from('barang');
        $this->db->join('barang_masuk', 'barang.kode_barang = barang_masuk.barang_id', 'left');
        $this->db->join('barang_keluar', 'barang.kode_barang = barang_keluar.barang_id', 'left');

        if ($startDate && $endDate) {
            $this->db->group_start()
                ->where('tanggal_masuk >=', $startDate)
                ->where('tanggal_masuk <=', $endDate)
                ->or_where('tanggal_keluar >=', $startDate)
                ->where('tanggal_keluar <=', $endDate)
                ->group_end();
        }

        $this->db->group_by('barang.id_barang, nama_barang, stok_awal, stok');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllLaporanData()
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('barang_masuk', 'barang.kode_barang = barang_masuk.barang_id', 'left');
        $this->db->join('barang_keluar', 'barang.kode_barang = barang_keluar.barang_id', 'left');
        $this->db->group_by('barang.id_barang');

        $query = $this->db->get();
        return $query->result_array();
    }
}
