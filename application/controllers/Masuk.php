<?php

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Other_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Barang Masuk';
        $data['setting'] = $this->Other_model->getSetting();

        $barangId = $this->input->get('barang_id');
        $kondisiBarang = $this->input->get('kondisi_barang');

        if ($this->input->get('isDownloadExcel') == 'unduhExcel') {
            $this->excel($barangId, $kondisiBarang);
            exit();
        }

        if ($this->input->get('isDownloadPDF') == 'unduhPDF') {
            $this->pdf($barangId, $kondisiBarang);
            exit();
        }

        $data['barangmasuk'] = $this->admin->getBarangMasuk($barangId, $kondisiBarang);

        $data['jenis'] = $this->admin->get('jenis');
        $data['satuan'] = $this->admin->get('satuan');
        $data['supplier'] = $this->admin->get('suplier');
        $data['barang'] = $this->admin->get('barang');

        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_masuk', 'Barang', 'required|trim|numeric|greater_than[0]');

        if ($this->form_validation->run() == false) {
            // mendapatkan menggenerate otomatis kode transaksi
            $kode = 'T-BM-' . date('dmY');
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'id_bmasuk', $kode);
            if ($kode_terakhir) {
                $kode_tambah = substr($kode_terakhir, -4, 4);
                $kode_tambah++;
            } else {
                $kode_tambah = 1;
            }
            $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
            $data['id_bmasuk'] = $kode . $number;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar');
            $this->load->view('transaksi/barang_masuk/masuk');
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_bmasuk' => $this->input->post('id_bmasuk'),
                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                'id_supplier' => $this->input->post('id_supplier'),
                'id_user' => $this->input->post('id_user'),
                'barang_id' => $this->input->post('barang_id'),
                'jumlah_masuk' => $this->input->post('jumlah_masuk')
            ];

            $insert = $this->db->insert('barang_masuk', $data);
            if ($insert == false) {
                set_pesan('Data gagal disimpan, periksa kembali!');
            } else {
                set_pesan('Data berhasil disimpan.');
            }

            redirect('masuk');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $this->admin->delete('barang_masuk', 'id_bmasuk', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('masuk');
    }

    private function excel($barangId, $kondisiBarang)
    {
        $dataBarang = $this->admin->getBarangMasuk($barangId, $kondisiBarang);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns according to requested format
        $headerColumns = ['No', 'No Transaksi', 'Tanggal Masuk', 'Nama Barang', 'Jumlah Masuk', 'Supplier', 'Petugas', 'Harga', 'Total Harga'];

        foreach ($headerColumns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => array_fill_keys(['top', 'right', 'bottom', 'left'], ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]),
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'F0F0F0']
                ]
            ]);
        }

        $row = 2;
        foreach ($dataBarang as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1); // No
            $sheet->setCellValue('B' . $row, $item['id_bmasuk']); // No Transaksi (assuming 'id' is the transaction number)
            $sheet->setCellValue('C' . $row, $item['tanggal_masuk']); // Tanggal Masuk
            $sheet->setCellValue('D' . $row, $item['nama_barang']); // Nama Barang
            $sheet->setCellValue('E' . $row, $item['jumlah_masuk']); // Jumlah Masuk
            $sheet->setCellValue('F' . $row, $item['nama_supplier']); // Supplier
            $sheet->setCellValue('G' . $row, $item['name']); // Petugas (assuming 'name' is the staff name)
            $sheet->setCellValue('H' . $row, $item['harga']); // Harga
            $sheet->setCellValue('I' . $row, $item['harga'] * $item['jumlah_masuk']); // Total Harga

            $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => array_fill_keys(['top', 'right', 'bottom', 'left'], ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN])
            ]);

            $row++;
        }

        // Format tanggal
        $sheet->getStyle('C2:C' . ($row - 1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');

        // Format harga
        $sheet->getStyle('H2:H' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I2:I' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');

        // Total untuk Jumlah Masuk dan Harga
        $sheet->setCellValue('E' . $row, "=SUM(E2:E" . ($row - 1) . ")");
        $sheet->setCellValue('H' . $row, "=SUM(H2:H" . ($row - 1) . ")");
        $sheet->setCellValue('I' . $row, "=SUM(I2:I" . ($row - 1) . ")");

        // Label TOTAL
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL:');

        $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => array_fill_keys(['top', 'right', 'bottom', 'left'], ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]),
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'F0F0F0']
            ]
        ]);

        // Format total row for numbers
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');

        // Auto-width semua kolom
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data-barang-masuk.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function pdf($barangId, $kondisiBarang)
    {
        // Load view untuk generate HTML
        $data['barang'] = $this->admin->getBarangMasuk($barangId, $kondisiBarang);
        $html = $this->load->view('transaksi/barang_masuk/cetak', $data, true);

        // Buat instance Dompdf
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'landscape'); // Ubah ke landscape

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Render HTML ke PDF
        $dompdf->render();

        // Set nama file PDF yang akan di-download
        $filename = 'laporan_data_barang.pdf';

        // Outputkan file PDF ke browser untuk di-download
        $dompdf->stream($filename, array('Attachment' => 0));
    }
}
