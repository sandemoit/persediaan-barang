<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
        $data['title'] = 'Profile';
        $data['setting'] = $this->Other_model->getSetting();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('profile/profile', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'nohp' => $this->input->post('nohp')
        ];

        $this->Admin_model->update('user', 'id', $id, $data);
        set_pesan('profile berhasil diupdate');
        redirect('profile');
    }

    public function image()
    {
        // Check if user is logged in
        if (!$this->session->userdata('email')) {
            set_pesan('Anda harus login terlebih dahulu.', false);
            redirect('login');
        }

        // Get user data
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id_user = $this->input->post('id', true);

        // Validate user ID
        if (empty($id_user) || $id_user != $data['user']['id']) {
            set_pesan('ID user tidak valid.', false);
            redirect('profile');
        }

        // Upload configuration
        $config['upload_path'] = './assets/images/avatar/'; // Note the ./ at beginning
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB in KB
        $config['max_width'] = 2000;
        $config['max_height'] = 2000;
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;
        $config['overwrite'] = false;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
            // Upload failed
            $error = $this->upload->display_errors();
            set_pesan('Gagal mengupload foto: ' . $error, false);
            redirect('profile');
        } else {
            // Upload success
            $upload_data = $this->upload->data();
            $new_image = $upload_data['file_name'];

            // Delete old image if it's not default
            $old_image = $data['user']['image'];
            if ($old_image != 'default.jpg' && file_exists(FCPATH . 'assets/images/avatar/' . $old_image)) {
                unlink(FCPATH . 'assets/images/avatar/' . $old_image);
            }

            // Update database
            $this->db->where('id', $id_user);
            $update = $this->db->update('user', ['image' => $new_image]);

            if ($update) {
                set_pesan('Foto profil berhasil diupdate.');
            } else {
                // If DB update fails, delete the uploaded image
                unlink($upload_data['full_path']);
                set_pesan('Gagal mengupdate database.', false);
            }

            redirect('profile');
        }
    }

    public function changepassword()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password';
        $data['setting'] = $this->Other_model->getSetting();

        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('baru_1', 'Password Baru', 'required|trim|min_length[3]|matches[baru_2]');
        $this->form_validation->set_rules('baru_2', 'Konfirmasi Password', 'required|trim|matches[baru_1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('profile/changepassword', $data);
            $this->load->view('template/footer', $data);
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('baru_1');
            if (!password_verify($password_lama, $data['user']['password'])) {
                set_pesan('Password lama salah!', false);
                redirect('profile/changepassword');
            } else {
                if ($password_lama == $password_baru) {
                    set_pesan('Password baru tidak boleh sama dengan kata sandi saat ini!', false);
                    redirect('profile/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                    $last = [
                        'last_change_pw' => time()
                    ];
                    $this->db->set($last);
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    set_pesan('Berhasil ganti password!');
                    redirect('profile/changepassword');
                }
            }
        }
    }
}
