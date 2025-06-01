<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('M_Pelanggan', 'pelanggan');
        $this->load->model('Other_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Barang Keluar';
        $data['setting'] = $this->Other_model->getSetting();
        $data['barangkeluar'] = $this->Admin_model->getBarangKeluar();
        $data['barang'] = $this->db->get('barang')->result_array();

        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Barang', 'required|trim');

        $kode = 'T-BK-' . date('dmY');
        $kode_terakhir = $this->Admin_model->getMax('barang_keluar', 'id_bkeluar', $kode);
        if ($kode_terakhir) {
            $kode_tambah = substr($kode_terakhir, -4, 4);
            $kode_tambah++;
        } else {
            $kode_tambah = 1;
        }
        $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
        $data['id_bkeluar'] = $kode . $number;
        $data['no_surat'] = 'ST ' . $number;

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('transaksi/barang_keluar/keluar', $data);
            $this->load->view('template/footer');
        } else {
            // Cek stok barang sebelum memproses transaksi
            $barang_id = $this->input->post('barang_id');
            $noTransaksi = $this->input->post('id_bkeluar');
            $jumlah_keluar = $this->input->post('jumlah_keluar');

            $stok_barang = $this->Admin_model->getStokBarang($barang_id);
            if ($stok_barang >= $jumlah_keluar) {
                // Jika stok mencukupi, lanjutkan transaksi
                $data = [
                    'id_bkeluar' => $noTransaksi,
                    'id_user' => $this->input->post('id_user'),
                    'barang_id' => $barang_id,
                    'jumlah_keluar' => $jumlah_keluar,
                    'tanggal_keluar' => $this->input->post('tanggal_keluar')
                ];

                $this->db->insert('barang_keluar', $data);
                set_pesan('Data berhasil disimpan.');
            } else {
                // Jika stok tidak mencukupi, beri pesan kesalahan
                set_pesan('Stok barang tidak mencukupi.', false);
            }
            redirect('keluar');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $this->Admin_model->delete('barang_keluar', 'id_bkeluar', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('keluar');
    }

    public function detail($idBkeluar)
    {
        // $data = $this->pelanggan->getDataPelanggan($idBkeluar);
        // echo json_encode($data);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['setting'] = $this->Other_model->getSetting();
        $data['title'] = 'Detail Barang Keluar';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('transaksi/pelanggan/detail', $data);
        $this->load->view('template/footer');
    }

    /**
     * Controller method untuk unduh surat - hanya berdasarkan nomor surat
     */
    public function unduhSurat()
    {
        // Set response headers
        header('Content-Type: application/json');

        try {
            $no_surat = $this->input->post('no_surat');

            // Validasi input
            if (empty($no_surat)) {
                throw new Exception('Nomor surat harus dipilih untuk mengunduh');
            }

            // Proses unduh berdasarkan nomor surat
            $result = $this->downloadSuratByNumber($no_surat);

            // Return JSON response
            echo json_encode($result);
            return;
        } catch (Exception $e) {
            $error_response = [
                'success' => false,
                'message' => $e->getMessage()
            ];

            echo json_encode($error_response);
            return;
        }
    }

    /**
     * Method untuk download surat berdasarkan nomor surat saja
     */
    private function downloadSuratByNumber($no_surat)
    {
        try {
            // Ambil data berdasarkan nomor surat
            $data = $this->getDataByNoSurat($no_surat);

            if (empty($data)) {
                throw new Exception('Data tidak ditemukan untuk nomor surat: ' . $no_surat);
            }

            // Generate filename dan title
            $filename = 'surat-keluar-' . str_replace('/', '-', $no_surat) . '-' . date('Y-m-d-H-i-s') . '.pdf';
            $title = 'Surat Keluar - ' . $no_surat;

            // Generate PDF
            $file_info = $this->generatePDFFile($data, $filename, $title, $no_surat);

            $result = [
                'success' => true,
                'message' => 'File PDF berhasil dibuat dan siap diunduh',
                'download_url' => base_url('keluar/downloadFile/' . urlencode($filename)),
                'filename' => $filename,
                'file_size' => $this->formatBytes(filesize($file_info['path'])),
                'total_items' => count($data)
            ];

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Method untuk mengambil data berdasarkan nomor surat saja
     */
    private function getDataByNoSurat($no_surat)
    {
        // Query untuk mendapatkan semua data berdasarkan nomor surat
        $this->db->select('
        bk.id_bkeluar,
        bk.no_surat,
        bk.jumlah_keluar,
        bk.tanggal_keluar,
        b.kode_barang,
        b.nama_barang,
        p.nama as nama_pelanggan,
        p.kode_toko,
        p.alamat,
        s.nama_satuan
    ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.barang_id = b.kode_barang', 'left');
        $this->db->join('pelanggan p', 'bk.pelanggan_id = p.id_pelanggan', 'left');
        $this->db->join('satuan s', 'b.id_satuan = s.id', 'left');
        $this->db->where('bk.no_surat', $no_surat);
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        $this->db->order_by('bk.id_bkeluar', 'ASC');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    /**
     * Method untuk generate PDF file (updated)
     */
    private function generatePDFFile($data, $filename, $title, $no_surat = null)
    {
        // Ambil setting perusahaan
        $setting = $this->Other_model->getSetting();

        // Siapkan data untuk view
        $pdf_data = [
            'title' => $title,
            'data' => $data,
            'no_surat' => $no_surat,
            'setting' => $setting,
            'nama_pelanggan' => $data[0]['nama_pelanggan'] ?? '',
            'alamat_pelanggan' => $data[0]['alamat'] ?? '',
            'generated_date' => date('d/m/Y H:i:s'),
            'total_items' => count($data)
        ];

        // Load view dan convert ke string
        $html = $this->load->view('transaksi/pelanggan/cetak-surat', $pdf_data, TRUE);

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');

        // Inisialisasi DomPDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Pastikan folder downloads ada
        $upload_path = FCPATH . 'downloads/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Simpan PDF ke file
        $file_path = $upload_path . $filename;
        file_put_contents($file_path, $dompdf->output());

        return [
            'path' => $file_path,
            'filename' => $filename
        ];
    }

    /**
     * Method untuk download file (tetap sama)
     */
    public function downloadFile($filename = '')
    {
        $filename = urldecode($filename);

        // Validasi filename untuk keamanan
        if (empty($filename) || strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
            show_404();
            return;
        }

        $file_path = FCPATH . 'downloads/' . $filename;

        if (file_exists($file_path) && is_file($file_path)) {
            // Set headers untuk download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($file_path));
            header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
            header('Pragma: public');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

            // Bersihkan output buffer
            ob_clean();
            flush();

            // Output file
            readfile($file_path);

            // Hapus file setelah download untuk menghemat space
            @unlink($file_path);
            exit;
        } else {
            show_404();
        }
    }

    /**
     * Method untuk format ukuran file
     */
    private function formatBytes($size, $precision = 2)
    {
        if ($size <= 0) return '0 B';

        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    /**
     * Method untuk cleanup file lama (opsional)
     */
    public function cleanupOldFiles()
    {
        $upload_path = FCPATH . 'downloads/';
        $cleaned = 0;

        if (is_dir($upload_path)) {
            $files = glob($upload_path . '*.pdf');
            $now = time();

            foreach ($files as $file) {
                if (is_file($file)) {
                    // Hapus file yang lebih dari 1 jam
                    if ($now - filemtime($file) >= 3600) {
                        if (unlink($file)) {
                            $cleaned++;
                        }
                    }
                }
            }
        }

        echo json_encode([
            'success' => true,
            'message' => "Berhasil membersihkan $cleaned file lama"
        ]);
    }
}
