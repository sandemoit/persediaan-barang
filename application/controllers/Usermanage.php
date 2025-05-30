<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermanage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
        is_logged_in();
        if (!is_admin()) {
            redirect('dashboard');
        }
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->where('email !=', 'sandimaulidika@gmail.com');
        $data['title'] = 'User Management';
        $data['setting'] = $this->Other_model->getSetting();
        $data['userm'] = $this->Admin_model->get('user');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password1]');
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('other/usermanage', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => htmlspecialchars(password_hash($this->input->post('password1'), PASSWORD_DEFAULT)),
                'name' => htmlspecialchars($this->input->post('name', true)),
                'image' => 'default.jpg',
                'date_created' => time(),
                'role' => htmlspecialchars($this->input->post('role', true)),
                'is_active' => 1
            ];

            // jika validasi lolos
            $save = $this->Admin_model->insert('user', $data);
            if ($save) {
                set_pesan('User berhasil ditambah!');
            } else {
                set_pesan('User gagal ditambah!', false);
            }
            redirect('usermanage');
        }
    }

    public function edit()
    {
        $id = intval($this->input->post('id'));

        $data = [
            'email' => filter_var($this->input->post('email'), FILTER_SANITIZE_EMAIL),
            'role' => filter_var($this->input->post('role'), FILTER_SANITIZE_STRING),
            'name' => filter_var($this->input->post('name'), FILTER_SANITIZE_STRING)
        ];

        if ($id > 0 && !empty($data)) {
            if ($this->Admin_model->update('user', 'id', $id, $data)) {
                set_pesan('Data berhasil diubah!');
            } else {
                set_pesan('Terjadi kesalahan saat menyimpan data.', FALSE);
            }
        }

        redirect('usermanage');
    }

    public function toggle($getId)
    {
        $id = encode_php_tags($getId);
        $status = $this->Admin_model->get('user', ['id' => $id])['is_active'];
        $toggle = $status ? 0 : 1; //Jika user aktif maka nonaktifkan, begitu pula sebaliknya
        $pesan = $toggle ? 'user diaktifkan.' : 'user dinonaktifkan.';

        if ($this->Admin_model->update('user', 'id', $id, ['is_active' => $toggle])) {
            set_pesan($pesan);
        }
        redirect('usermanage');
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->Admin_model->delete('user', 'id', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('usermanage');
    }
}
