<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $data['title'] = 'Supplier';
        $data['setting'] = $this->Other_model->getSetting();
        $data['supplier'] = $this->Admin_model->get('suplier');

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim|is_unique[suplier.nama_supplier]', [
            'is_unique' => 'Nama Supplier sudah ada!'
        ]);
        $this->form_validation->set_rules(
            'nohp',
            'No Telphone',
            'required|trim|numeric|min_length[10]|max_length[13]|is_unique[suplier.nohp]',
            [
                'is_unique' => 'No Telphone sudah ada!',
                'numeric' => 'No Telphone harus angka!',
                'min_length' => 'No Telphone minimal 10 angka!',
                'max_length' => 'No Telphone maximal 13 angka!'
            ]
        );
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('supplier/index', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'nohp' => $this->input->post('nohp'),
                'alamat' => $this->input->post('alamat'),
                'email' => $this->input->post('email'),
            ];
            $save = $this->Admin_model->insert('suplier', $data);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('supplier');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('supplier');
            }
        }
    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['supplier'] = $this->Admin_model->get('suplier');

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('nohp', 'No Telphone', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        $data = [
            'nama_supplier' => $this->input->post('nama_supplier'),
            'nohp' => $this->input->post('nohp'),
            'alamat' => $this->input->post('alamat'),
            'email' => $this->input->post('email'),
        ];
        $this->Admin_model->update('suplier', 'id', $id, $data);
        set_pesan('data berhasil disimpan!');
        redirect('supplier');
    }

    public function delete($id)
    {
        $this->db->delete('suplier', ['id' => $id]);
        set_pesan('data berhasil dihapus!');
        redirect('supplier');
    }
}
