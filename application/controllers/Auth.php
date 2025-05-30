<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Other_model');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('dashboard');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Sistem Informasi Gudang';
            $data['setting'] = $this->db->get('setting')->row_array();
            $this->load->view('auth', $data);
        } else {
            // validasi sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role' => $user['role']
                    ];
                    $this->session->set_userdata($data);
                    redirect('dashboard');
                } else {
                    set_pesan('password salah!', false);
                    redirect('auth');
                }
            } else {
                set_pesan('email belum aktif/dinonaktifkan, hubungi admin!', false);
                redirect('auth');
            }
        } else {
            set_pesan('email belum terdaftar!', false);
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        set_pesan('Anda telah keluar dari sistem');
        redirect('auth');
    }
}
