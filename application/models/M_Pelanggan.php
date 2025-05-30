<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Pelanggan extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function get_by_id($table, $primary_key, $id)
    {
        $this->db->where($primary_key, $id);
        $query = $this->db->get($table);

        // Check if there is a matching record
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getTrx($barangId = null, $kondisiBarang = null, $noSurat = null)
    {
        $this->db->select('
        barang_keluar.*,
        barang.nama_barang,
        barang.kondisi,
        barang.harga,
        satuan.nama_satuan,
        pelanggan.nama
    ');
        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang_keluar.barang_id = barang.kode_barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = barang_keluar.pelanggan_id');
        $this->db->where('barang_keluar.pelanggan_id IS NOT NULL');

        if (!empty($barangId)) {
            $this->db->where('barang_keluar.barang_id', $barangId);
        }

        if (!empty($noSurat)) {
            $this->db->where('barang_keluar.no_surat', $noSurat);
        }

        if (!empty($kondisiBarang)) {
            $this->db->where('barang.kondisi', $kondisiBarang);
        }

        $this->db->order_by('barang_keluar.tanggal_keluar', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataPelanggan($id)
    {
        $this->db->where('id_pelanggan', $id);
        $query = $this->db->get('pelanggan');
        return $query->row_array();
    }

    public function getTotalTrx($id, $startDate = null, $endDate = null)
    {
        $this->db->where('pelanggan_id', $id);
        if ($startDate && $endDate) {
            $this->db->where('tanggal_keluar >=', $startDate);
            $this->db->where('tanggal_keluar <=', $endDate);
        }

        $query = $this->db->get('barang_keluar');
        return $query->num_rows();
    }

    public function getSales($startDate = null, $endDate = null, $id = null)
    {
        $this->db->select('barang_keluar.id_bkeluar, nama_barang, nama_jenis, jumlah_keluar, tanggal_keluar');

        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang.kode_barang = barang_keluar.barang_id', 'left');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id', 'left');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = barang_keluar.pelanggan_id', 'left');

        if ($startDate && $endDate) {
            $this->db->where('tanggal_keluar >=', $startDate);
            $this->db->where('tanggal_keluar <=', $endDate);
        }

        $this->db->where('barang_keluar.pelanggan_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllLaporanData($id)
    {
        $this->db->select('barang_keluar.id_bkeluar, nama_barang, nama_jenis, jumlah_keluar, tanggal_keluar');

        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang.id_barang = barang_keluar.barang_id', 'left');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id', 'left');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = barang_keluar.pelanggan_id', 'left');

        $this->db->where('barang_keluar.pelanggan_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function salesChart($id, $startDate = null, $endDate = null)
    {
        $this->db->select('DATE(tanggal_keluar) as tanggal, SUM(jumlah_keluar) as total_keluar');
        $this->db->where('pelanggan_id', $id);
        if ($startDate && $endDate) {
            $this->db->where('DATE(tanggal_keluar) >=', $startDate);
            $this->db->where('DATE(tanggal_keluar) <=', $endDate);
        }
        $this->db->group_by('tanggal');

        $query = $this->db->get('barang_keluar');

        return $query->result_array();
    }

    public function getKeluar($id)
    {
        $this->db->where('id_bkeluar', $id);
        $query = $this->db->get('barang_keluar');
        return $query->row_array();
    }

    public function getDetailKeluar($id)
    {
        $this->db->select('barang_keluar.*, barang.nama_barang, pelanggan.nama as nama_pelanggan');
        $this->db->from('barang_keluar');
        $this->db->join('barang', 'barang_keluar.barang_id = barang.kode_barang');
        $this->db->join('pelanggan', 'barang_keluar.pelanggan_id = pelanggan.id_pelanggan');
        $this->db->where('id_bkeluar', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
