<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import_excel extends CI_Controller
{

    // Menentukan nama file
    private $filename = "import_data";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterbarang_model');
        $this->load->model('Kategori_model');
        $this->load->model('Satuan_model');
        $this->load->library('form_validation');
    }

    public function form()
    {
        // $data['user'] = $this->db->get_where('user', ['email' =>
        // $this->session->userdata('email')])->row_array();
        // $data['mbarang'] = $this->Masterbarang_model->getAllMasterbarang();

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->ImportExcel_model->upload_file($this->filename);

            if ($upload['result'] == "success") { // Jika proses upload sukses
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet;
            } else { // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }

        $array['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $array['mbarang'] = $this->Masterbarang_model->getAllMasterbarang();
        $array['kategori'] = $this->Kategori_model->getAllKategori();


        $this->load->view('templates/master_header');
        $this->load->view('superadmin/masterbarang/form', $array, $data);
        $this->load->view('templates/master_footer');
    }

    public function import()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();

        $numrow = 1;
        foreach ($sheet as $row) {
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if ($numrow > 1) {
                // Kita push (add) array data ke variabel data
                array_push($data, array(
                    'kode_barang' => $row['A'], // Insert data nis dari kolom A di excel
                    'nama_barang' => $row['B'], // Insert data nama dari kolom B di excel
                    'nama_kategori' => $row['C'], // Insert data jenis kelamin dari kolom C di excel
                    'kondisi_barang' => $row['D'], // Insert data alamat dari kolom D di excel
                    'nomor_serial' => $row['E'], // Insert data nis dari kolom A di excel
                    'nomor_produk' => $row['F'], // Insert data nis dari kolom A di excel
                    'keterangan_barang' => $row['G'], // Insert data nis dari kolom A di excel
                    'batas' => $row['H'], // Insert data nis dari kolom A di excel
                    'nama_satuan' => $row['I'], // Insert data nis dari kolom A di excel
                    'photo' => $row['J'], // Insert data nis dari kolom A di excel
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
        $this->Masterbarang_model->insert_multiple($data);

        redirect("masterbarang/index"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }
}
