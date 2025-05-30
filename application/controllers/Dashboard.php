<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Other_model');
        $this->load->model('Admin_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $data['setting'] = $this->Other_model->getSetting();
        $data['barang'] = $this->Admin_model->getBarang();
        $data['products'] = $this->Admin_model->get_low_stock_products();
        // count
        $data['total_barang'] = $this->db->count_all('barang');
        $data['total_barang_masuk'] = $this->db->count_all('barang_masuk');
        $data['total_barang_keluar'] = $this->db->count_all('barang_keluar');
        $data['total_users'] = $this->db->count_all('user');

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }
}
