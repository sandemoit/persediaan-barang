<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
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

    public function update($table, $column, $id, $data)
    {
        // Membuat query untuk melakukan update data dengan klausa WHERE yang ditentukan
        $this->db->where($column, $id);
        $this->db->update($table, $data);

        // Mengembalikan hasil query
        return $this->db->affected_rows();
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function getBarang($kondisiBarang = null, $jenisBarang = null, $satuanBarang = null)
    {
        $query = "
            SELECT *
            FROM barang
            LEFT JOIN jenis ON barang.id_jenis = jenis.id
            LEFT JOIN satuan ON barang.id_satuan = satuan.id
            LEFT JOIN suplier ON barang.id_supplier = suplier.id
        ";

        $filters = [];

        if (!empty($kondisiBarang)) {
            $filters[] = "barang.kondisi = " . $this->db->escape($kondisiBarang);
        }

        if (!empty($jenisBarang)) {
            $filters[] = "barang.id_jenis = " . $this->db->escape($jenisBarang);
        }

        if (!empty($satuanBarang)) {
            $filters[] = "barang.id_satuan = " . $this->db->escape($satuanBarang);
        }

        if (!empty($filters)) {
            $query .= " WHERE " . implode(" AND ", $filters);
        }

        $query .= " ORDER BY barang.date_update DESC";

        return $this->db->query($query)->result_array();
    }

    public function editImageById($id)
    {
        $query = "
            SELECT *
            FROM barang
            WHERE id_barang = $id
            ORDER BY barang.date_update DESC
        ";

        return $this->db->query($query)->row_array();
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    // barang masuk
    public function getBarangMasuk($barangId = null, $kondisiBarang = null)
    {
        $this->db->select('
        barang_masuk.*,
        sp.nama_supplier,
        b.nama_barang,
        b.kondisi,
        u.name,
        b.harga
    ');
        $this->db->from('barang_masuk');
        $this->db->join('suplier sp', 'barang_masuk.id_supplier = sp.id');
        $this->db->join('barang b', 'barang_masuk.barang_id = b.kode_barang');
        $this->db->join('user u', 'barang_masuk.id_user = u.id');

        if (!empty($barangId)) {
            $this->db->where('barang_masuk.barang_id', $barangId);
        }

        if (!empty($kondisiBarang)) {
            $this->db->where('b.kondisi', $kondisiBarang);
        }

        $this->db->order_by('barang_masuk.tanggal_masuk', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    // barang keluar
    public function getBarangKeluar($barangId = null, $kondisiBarang = null)
    {
        $this->db->select('
        barang_keluar.*,
        u.name,
        b.nama_barang,
        b.kondisi,
        b.harga,
        s.nama_satuan
    ');
        $this->db->from('barang_keluar');
        $this->db->join('user u', 'barang_keluar.id_user = u.id');
        $this->db->join('barang b', 'barang_keluar.barang_id = b.kode_barang');
        $this->db->join('satuan s', 'b.id_satuan = s.id');

        if (!empty($barangId)) {
            $this->db->where('barang_keluar.barang_id', $barangId);
        }

        if (!empty($kondisiBarang)) {
            $this->db->where('b.kondisi', $kondisiBarang);
        }

        $this->db->order_by('barang_keluar.tanggal_keluar', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function cekStok($kode)
    {
        return $this->db->get_where('barang', ['kode_barang' => $kode])->row('stok') ?? null;
    }

    public function get_low_stock_products()
    {
        // Ambil nilai low_stok dari tabel setting
        $query_setting = $this->db->get('setting');
        $setting_data = $query_setting->row();
        $low_stok_value = $setting_data->low_stok;

        // Buat query utama dengan kondisi berdasarkan low_stok
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id');
        $this->db->where('barang.stok <', $low_stok_value);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function cetak()
    {
        $this->db->select('barang.*, satuan.nama_satuan, jenis.nama_jenis');
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStokBarang($barang_id)
    {
        $this->db->select('stok');
        $this->db->from('barang');
        $this->db->where('kode_barang', $barang_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->stok;
        } else {
            return 0; // Jika barang tidak ditemukan, return 0 atau nilai default yang sesuai
        }
    }
}
