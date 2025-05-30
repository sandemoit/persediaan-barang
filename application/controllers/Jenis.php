<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Jenis Barang";
        $data['setting'] = $this->Other_model->getSetting();
        $data['jenis'] = $this->Admin_model->get('jenis');

        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/jenis', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_jenis' => $this->input->post('nama_jenis')
            ];
            $this->Admin_model->insert('jenis', $data);
            set_pesan('data berhasil ditambah!');
            redirect('jenis');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required|trim');

        $data = [
            'nama_jenis' => $this->input->post('nama_jenis')
        ];

        $this->Admin_model->update('jenis', 'id', $id, $data);
        set_pesan('Data berhasil diubah!');
        redirect('jenis');
    }

    public function delete($id)
    {
        $id = encode_php_tags($id);
        $this->Admin_model->delete('jenis', 'id', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('jenis');
    }
}
