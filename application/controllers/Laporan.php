<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Other_model');
        $this->load->model('Laporan_model');
        $this->load->library('Dompdf_gen');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan Barang Masuk & Keluar';
        $data['setting'] = $this->Other_model->getSetting();

        // Periksa apakah ada input start_date dan end_date dari POST
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Panggil model untuk mendapatkan data laporan berdasarkan tanggal
        $data['laporan'] = $this->Laporan_model->getLaporanData($start_date, $end_date);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('template/footer');
    }

    public function excel()
    {
        // Dapatkan nilai start_date dan end_date dari permintaan GET
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        // Ambil data laporan dari model
        if ($start_date !== null && $end_date !== null) {
            $laporan = $this->Laporan_model->getLaporanData($start_date, $end_date);
        } else {
            $laporan = $this->Laporan_model->getAllLaporanData();
        }

        // Load library PHPSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Setel header kolom
        $headerColumns = ['No', 'ID Barang', 'Nama Barang', 'Stok Awal', 'Jumlah Masuk', 'Jumlah Keluar', 'Total Stok'];
        foreach ($headerColumns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);

            // Terapkan gaya header
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'F0F0F0']
                ]
            ]);
        }

        // Isi data ke dalam Spreadsheet
        $row = 2;
        foreach ($laporan as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['kode_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_barang']);
            $sheet->setCellValue('D' . $row, $item['stok_awal']);
            $sheet->setCellValue('E' . $row, $item['jumlah_masuk']);
            $sheet->setCellValue('F' . $row, $item['jumlah_keluar']);
            $sheet->setCellValue('G' . $row, $item['stok']);

            // Terapkan gaya baris
            $style_row = [
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($style_row);

            $row++;
        }

        // Set lebar kolom
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Atur header untuk file Excel
        $filename = 'Laporan-barang.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Simpan Spreadsheet ke file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }

    public function cetak()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        if ($start_date !== null && $end_date !== null) {
            $data['laporan'] = $this->Laporan_model->getLaporanData($start_date, $end_date);
        } else {
            $data['laporan'] = $this->Laporan_model->getAllLaporanData();
        }

        $data['title'] = 'Laporan Barang';
        $data['start_date'] = tanggal($start_date);
        $data['end_date'] = tanggal($end_date);

        $this->load->view('laporan/print', $data);
    }

    public function pdf()
    {
        // Ambil nilai dari form
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Setel ke null jika tidak terdefinisi
        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        // Ambil data berdasarkan rentang tanggal jika start_date dan end_date terdefinisi
        if ($start_date !== null && $end_date !== null) {
            $data['laporan'] = $this->Laporan_model->getLaporanData($start_date, $end_date);
        } else {
            // Jika start_date atau end_date kosong, tampilkan semua data
            $data['laporan'] = $this->Laporan_model->getAllLaporanData();
        }

        $data['title'] = 'Laporan Barang';
        $data['start_date'] = tanggal($start_date);
        $data['end_date'] = tanggal($end_date);

        // Load library DOMPDF
        $this->load->library('Dompdf_gen');

        // Set konten PDF
        $html = $this->load->view('laporan/pdf', $data, true);
        // Buat instance Dompdf
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Atur konfigurasi PDF, misalnya ukuran kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF (output)
        $dompdf->render();

        // Stream PDF ke browser
        $dompdf->stream('laporan.pdf', array('Attachment' => 0));
    }

    // public function filter()
    // {
    //     // Ambil nilai dari form
    //     $tanggal_awal = $this->input->post('tanggal_awal');
    //     $tanggal_akhir = $this->input->post('tanggal_akhir');

    //     // Query database sesuai dengan jenis laporan
    //     $laporanData = $this->Other_model->getFilteredData($tanggal_awal, $tanggal_akhir);

    //     $data['laporan'] = $laporanData;
    //     $this->load->view('laporan_view', $data);
    // }
}
