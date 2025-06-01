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

    public function unduhSurat()
    {
        // Set response headers
        header('Content-Type: application/json');

        try {
            // Log untuk debugging
            log_message('debug', 'unduhSurat function called');

            $berdasarkan = $this->input->post('berdasarkan');
            $no_surat = $this->input->post('no_surat');
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');

            // Log input data
            log_message('debug', 'Input data: ' . json_encode([
                'berdasarkan' => $berdasarkan,
                'no_surat' => $no_surat,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]));

            // Validasi dasar
            if (empty($no_surat) && (empty($tanggal_awal) || empty($tanggal_akhir))) {
                throw new Exception('Pilih nomor surat atau isi rentang tanggal untuk mengunduh');
            }

            // Validasi tanggal jika keduanya diisi
            if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                if (strtotime($tanggal_awal) > strtotime($tanggal_akhir)) {
                    throw new Exception('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
                }
            }

            // Proses unduh berdasarkan parameter yang ada
            $result = $this->downloadSurat($no_surat, $tanggal_awal, $tanggal_akhir, $berdasarkan);

            // Log hasil
            log_message('debug', 'Download result: ' . json_encode($result));

            // Return JSON response langsung
            echo json_encode($result);
            return;
        } catch (Exception $e) {
            $error_response = [
                'success' => false,
                'message' => $e->getMessage()
            ];

            // Log error
            log_message('error', 'unduhSurat error: ' . $e->getMessage());

            echo json_encode($error_response);
            return;
        }
    }

    private function downloadSurat($no_surat = null, $tanggal_awal = null, $tanggal_akhir = null, $berdasarkan = null)
    {
        try {
            log_message('debug', 'downloadSurat called with params: ' . json_encode([
                'no_surat' => $no_surat,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
                'berdasarkan' => $berdasarkan
            ]));

            // Tentukan jenis pencarian dan ambil data
            if (!empty($no_surat)) {
                if ($berdasarkan === 'surat_jalan_hari_ini') {
                    // No surat dengan tanggal hari ini
                    log_message('debug', 'Using surat_jalan_hari_ini method');
                    $data = $this->getDataBySuratJalanAndDate($no_surat, $tanggal_awal, $tanggal_akhir);
                    $filename = 'surat-keluar-' . str_replace('/', '-', $no_surat) . '-' . date('Y-m-d') . '.pdf';
                    $title = 'Surat Keluar - ' . $no_surat . ' (' . date('d/m/Y') . ')';
                } else {
                    // No surat dengan rentang tanggal
                    log_message('debug', 'Using surat_jalan_rentang method');
                    $data = $this->getDataBySuratJalanAndDate($no_surat, $tanggal_awal, $tanggal_akhir);
                    $filename = 'surat-keluar-' . str_replace('/', '-', $no_surat) . '-' . $tanggal_awal . '-to-' . $tanggal_akhir . '.pdf';
                    $title = 'Surat Keluar - ' . $no_surat . ' (' . date('d/m/Y', strtotime($tanggal_awal)) . ' - ' . date('d/m/Y', strtotime($tanggal_akhir)) . ')';
                }
            } else {
                // Hanya berdasarkan rentang tanggal
                log_message('debug', 'Using rentang_tanggal method');
                $data = $this->getDataByRentangTanggal($tanggal_awal, $tanggal_akhir);
                $filename = 'surat-keluar-' . $tanggal_awal . '-to-' . $tanggal_akhir . '.pdf';
                $title = 'Surat Keluar ' . date('d/m/Y', strtotime($tanggal_awal)) . ' - ' . date('d/m/Y', strtotime($tanggal_akhir));
            }

            log_message('debug', 'Data count: ' . count($data));

            if (empty($data)) {
                throw new Exception('Data tidak ditemukan untuk kriteria yang dipilih');
            }

            // Generate PDF
            $file_info = $this->generatePDFFile($data, $filename, $title, $no_surat, $tanggal_awal, $tanggal_akhir);

            $result = [
                'success' => true,
                'message' => 'File PDF berhasil dibuat dan siap diunduh',
                'download_url' => base_url('keluar/downloadFile/' . urlencode($filename)),
                'filename' => $filename,
                'file_size' => $this->formatBytes(filesize($file_info['path']))
            ];

            log_message('debug', 'Success result: ' . json_encode($result));
            return $result;
        } catch (Exception $e) {
            log_message('error', 'downloadSurat error: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    private function getDataBySuratJalanAndDate($no_surat, $tanggal_awal, $tanggal_akhir)
    {
        log_message('debug', 'getDataBySuratJalanAndDate called: ' . json_encode([
            'no_surat' => $no_surat,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]));

        // Query untuk mendapatkan data berdasarkan nomor surat dan rentang tanggal
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
        $this->db->where('bk.tanggal_keluar >=', $tanggal_awal);
        $this->db->where('bk.tanggal_keluar <=', $tanggal_akhir);
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        $this->db->order_by('bk.id_bkeluar', 'ASC');

        $query = $this->db->get();
        $result = $query->result_array();

        // Log query untuk debugging
        log_message('debug', 'SQL Query: ' . $this->db->last_query());
        log_message('debug', 'Query result count: ' . count($result));

        return $result;
    }

    private function getDataByRentangTanggal($tanggal_awal, $tanggal_akhir)
    {
        log_message('debug', 'getDataByRentangTanggal called: ' . json_encode([
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]));

        // Query untuk mendapatkan data berdasarkan rentang tanggal saja
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
        $this->db->where('bk.tanggal_keluar >=', $tanggal_awal);
        $this->db->where('bk.tanggal_keluar <=', $tanggal_akhir);
        $this->db->order_by('bk.tanggal_keluar', 'DESC');
        $this->db->order_by('bk.no_surat', 'ASC');

        $query = $this->db->get();
        $result = $query->result_array();

        // Log query untuk debugging
        log_message('debug', 'SQL Query: ' . $this->db->last_query());
        log_message('debug', 'Query result count: ' . count($result));

        return $result;
    }

    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    private function generatePDFFile($data, $filename, $title, $no_surat = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        // Siapkan data untuk view
        $pdf_data = [
            'title' => $title,
            'data' => $data,
            'no_surat' => $no_surat,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'generated_date' => date('d/m/Y H:i:s')
        ];

        // Load view dan convert ke string
        $html = $this->load->view('transaksi/pelanggan/cetak-surat', $pdf_data, TRUE);

        // Konfigurasi DomPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

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

    // Method untuk membersihkan file lama (jalankan via cron job atau manual)
    public function cleanupOldFiles()
    {
        $upload_path = FCPATH . 'downloads/';
        $cleaned = 0;

        if (is_dir($upload_path)) {
            $files = glob($upload_path . '*.pdf');
            $now = time();

            foreach ($files as $file) {
                if (is_file($file)) {
                    // Hapus file yang lebih dari 2 jam
                    if ($now - filemtime($file) >= 7200) {
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
