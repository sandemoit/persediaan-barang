<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Barang extends CI_Controller
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
        $data['title'] = "Data Barang";

        $satuanBarang = $this->input->get('satuan_barang');
        $jenisBarang = $this->input->get('jenis_barang');
        $kondisiBarang = $this->input->get('kondisi_barang');

        if ($this->input->get('isDownloadExcel') == 'unduhExcel') {
            $this->excel($kondisiBarang, $jenisBarang, $satuanBarang);
            exit();
        }

        if ($this->input->get('isDownloadPDF') == 'unduhPDF') {
            $this->pdf($kondisiBarang, $jenisBarang, $satuanBarang);
            exit();
        }

        $data['barang'] = $this->admin->getBarang($kondisiBarang, $jenisBarang, $satuanBarang);

        $data['setting'] = $this->Other_model->getSetting();
        $data['jenis'] = $this->admin->get('jenis');
        $data['satuan'] = $this->admin->get('satuan');
        $data['supplier'] = $this->admin->get('suplier');

        // Mengenerate ID Barang
        $kode_terakhir = $this->admin->getMax('barang', 'kode_barang');
        $kode_tambah = substr($kode_terakhir, -4, 4);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
        $data['kode_barang'] = 'FS-' . $number;

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');
        $this->form_validation->set_rules('id_supplier', 'Satuan Supplier', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/barang', $data);
            $this->load->view('template/footer', $data);
        } else {
            $input_data = [
                'kode_barang' => $this->input->post('kode_barang', true),
                'nama_barang' => $this->input->post('nama_barang', true),
                'kondisi' => $this->input->post('kondisi', true),
                'harga' => $this->input->post('harga', true),
                'stok_awal' => $this->input->post('stok_awal', true),
                'stok' => $this->input->post('stok_awal', true),
                'id_jenis' => $this->input->post('id_jenis', true),
                'id_satuan' => $this->input->post('id_satuan', true),
                'id_supplier' => $this->input->post('id_supplier', true),
                'date_add' => date('Y-m-d H:i:s'),
                'date_update' => date('Y-m-d H:i:s')
            ];

            //cek jika ada gambar di upload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $upload_config['upload_path'] = FCPATH . 'assets/images/barang';
                $upload_config['allowed_types'] = 'jpg|png|jpeg';
                $upload_config['max_size'] = 2014;
                $upload_config['encrypt_name'] = true;

                $this->upload->initialize($upload_config);

                // Lakukan upload file
                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                    $this->db->set('image', $image);
                } else {
                    $error = $this->upload->display_errors();
                    set_pesan($error);
                }
            }

            $insert_result = $this->admin->insert('barang', $input_data);

            if ($insert_result) {
                set_pesan('Data berhasil ditambah!');
            } else {
                set_pesan('Data gagal ditambah!', false);
            }

            redirect('barang');
        }
    }

    public function edit($id)
    {
        $barang = $this->admin->editImageById($id);

        $data = [
            'nama_barang' => $this->input->post('nama_barang'),
            'stok_awal' => $this->input->post('stok_awal'),
            'id_jenis' => $this->input->post('id_jenis'),
            'id_satuan' => $this->input->post('id_satuan'),
            'id_supplier' => $this->input->post('id_supplier'),
            'date_update' => date('Y-m-d H:i:s')
        ];

        // cek jika ada gambar yang akan diupload
        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $upload_config['upload_path'] = FCPATH .  'assets/images/barang';
            $upload_config['allowed_types'] = 'jpg|png|jpeg';
            $upload_config['max_size'] = 2014;
            $upload_config['encrypt_name'] = true;

            $this->upload->initialize($upload_config);

            // Lakukan upload file
            if ($this->upload->do_upload('image')) {
                $old_image = $barang['image'];
                if ($old_image) {
                    unlink(FCPATH . 'assets/images/barang/' . $old_image);
                }
                $image = $this->upload->data('file_name');
                $this->db->set('image', $image);
            } else {
                $error = $this->upload->dispay_errors();
                set_pesan($error, false);
            }
        }

        // $this->admin->update('barang', 'id_barang', $id, $data);
        $this->db->where('id_barang', $id);
        $this->db->update('barang', $data);

        set_pesan('Data berhasil diubah!');
        redirect('barang');
    }

    public function delete($id)
    {
        $id = encode_php_tags($id);
        $this->admin->delete('barang', 'id_barang', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }

    private function excel($kondisiBarang, $jenisBarang, $satuanBarang)
    {
        $dataBarang = $this->admin->getBarang($kondisiBarang, $jenisBarang, $satuanBarang);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambah kolom Nama Supplier
        $headerColumns = ['No', 'ID Barang', 'Nama Barang', 'Jenis Barang', 'Satuan', 'Stok Awal', 'Stok Terbaru', 'Kondisi', 'Harga', 'Nama Supplier'];

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
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['kode_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_barang']);
            $sheet->setCellValue('D' . $row, $item['nama_jenis']);
            $sheet->setCellValue('E' . $row, $item['nama_satuan']);
            $sheet->setCellValue('F' . $row, $item['stok_awal']);
            $sheet->setCellValue('G' . $row, $item['stok']);
            $sheet->setCellValue('H' . $row, $item['kondisi']);
            $sheet->setCellValue('I' . $row, $item['harga']);
            $sheet->setCellValue('J' . $row, $item['nama_supplier']); // ⬅️ Kolom baru

            $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => array_fill_keys(['top', 'right', 'bottom', 'left'], ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN])
            ]);

            $row++;
        }

        // Total untuk F, G, I
        $sheet->setCellValue('F' . $row, "=SUM(F2:F" . ($row - 1) . ")");
        $sheet->setCellValue('G' . $row, "=SUM(G2:G" . ($row - 1) . ")");
        $sheet->setCellValue('I' . $row, "=SUM(I2:I" . ($row - 1) . ")");

        // Label TOTAL
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL:');

        $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
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

        // Auto-width semua kolom
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data-barang.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function pdf($kondisiBarang, $jenisBarang, $satuanBarang)
    {
        // Load view untuk generate HTML
        $data['barang'] = $this->admin->getBarang($kondisiBarang, $jenisBarang, $satuanBarang);
        $html = $this->load->view('master/cetak', $data, true);

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
