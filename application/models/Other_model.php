<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Other_model extends CI_Model
{
    public function getSetting()
    {
        return $this->db->get('setting')->row_array();
    }

    public function updateSetting($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function getSettingById($where)
    {
        $this->db->where('id', $where);
        $query = $this->db->get('setting');
        return $query->row_array();
    }

    public function getDataBarang()
    {

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id', 'left');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->group_by('barang.id_barang');  // Menghindari duplikasi data

        $query = $this->db->get();
        return $query->result_array();
    }
}
