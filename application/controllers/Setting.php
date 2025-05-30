<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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
        $data['title'] = "Setting Aplikasi";
        $data['setting'] = $this->Other_model->getSetting();

        $this->form_validation->set_rules('nama_aplikasi', 'Nama Aplikasi', 'required|trim');
        $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('notelpon', 'No Telphone', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('other/setting', $data);
            $this->load->view('template/footer');
        } else {
            $id = $this->input->post('id');
            $data = [
                'nama_aplikasi' => $this->input->post('nama_aplikasi'),
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'email' => $this->input->post('email'),
                'notelpon' => $this->input->post('notelpon'),
                'alamat' => $this->input->post('alamat'),
                'low_stok' => $this->input->post('low_stok'),
            ];

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = FCPATH . 'assets/images/';
                $config['file_name'] = uniqid(); // Menghasilkan nama unik untuk file

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    if ($old_image = $this->Other_model->getSettingById(1)['image']) {
                        unlink(FCPATH . 'assets/images/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    // Menangani jika terjadi kesalahan saat upload image
                    $error = $this->upload->display_errors();
                    set_pesan($error, FALSE); // handle error
                    redirect('setting');
                }
            }

            // jika validasi lolos
            $this->Admin_model->update('setting', 'id', 1, $data);
            set_pesan('Data berhasil diubah');
            redirect('setting');
        }
    }

    public function database()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Backup Database";
        $data['setting'] = $this->Other_model->getSetting();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('other/database', $data);
        $this->load->view('template/footer');
    }

    public function backupdb()
    {
        $this->load->dbutil();

        $db_name = 'backup-db-' . $this->db->database . '-' . date('d-m-Y') . '.sql';

        $prefs = array(
            'format' => 'sql',
            'filename' => $db_name,
            'add_insert' => TRUE,
            'foreign_key_checks' => FALSE,
        );

        $backup = $this->dbutil->backup($prefs);
        $save = 'pathtobkfolder/' . $db_name;

        write_file($save, $backup);
        force_download($db_name, $backup);
    }
}
