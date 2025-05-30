<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
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
        $data['title'] = "Satuan";
        $data['setting'] = $this->Other_model->getSetting();
        $data['satuan'] = $this->Admin_model->get('satuan');

        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/satuan', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_satuan' => $this->input->post('nama_satuan')
            ];
            $this->Admin_model->insert('satuan', $data);
            set_pesan('data berhasil ditambah!');
            redirect('satuan');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data['satuan'] = $this->Admin_model->get('satuan');

        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');

        $data = [
            'nama_satuan' => $this->input->post('nama_satuan')
        ];

        $this->Admin_model->update('satuan', 'id', $id, $data);
        set_pesan('Data berhasil diubah!');
        redirect('satuan');
    }

    public function delete($id)
    {
        $id = encode_php_tags($id);
        $this->Admin_model->delete('satuan', 'id', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('satuan');
    }
}
