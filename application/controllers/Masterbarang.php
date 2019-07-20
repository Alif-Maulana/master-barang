<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterbarang extends CI_Controller
{
    private $filename = "import_data";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterbarang_model');
        $this->load->model('Kategori_model');
        $this->load->model('Satuan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['mbarang'] = $this->Masterbarang_model->getAllMasterbarang();
        $data['kategori'] = $this->Kategori_model->getAllKategori();


        // $this->load->view('templates/master_header');
        // $this->load->view('superadmin/masterbarang/index', $data);
        // $this->load->view('templates/master_footer');

        $this->form_validation->set_rules('nama_kategori', 'Kategori', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/master_header');
            $this->load->view('superadmin/masterbarang/index', $data);
            $this->load->view('templates/master_footer');
        } else {
            $this->Kategori_model->CreateKategori();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Insert New Kategori!</div>');
            redirect('masterbarang/index');
        }
    }

    public function form()
    {

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->Masterbarang_model->upload_file($this->filename);

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

        // $data['user'] = $this->db->get_where('user', ['email' =>
        // $this->session->userdata('email')])->row_array();

        // $this->load->view('templates/master_header');
        $this->load->view('superadmin/masterbarang/form', $data);
        // $this->load->view('templates/master_footer');
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

    public function create()
    {
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['satuan'] = $this->Satuan_model->getAllSatuan();
        $data['kategori'] = $this->Kategori_model->getAllKategori();

        $this->load->view('templates/master_header');
        $this->load->view('superadmin/masterbarang/create', $data);
        $this->load->view('templates/master_footer');
    }

    public function store()
    {
        $this->Masterbarang_model->CreateMasterbarang();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Insert New Barang!</div>');
        redirect('masterbarang/index');
    }

    public function createsatuan()
    {
        $this->form_validation->set_rules('nama_satuan', 'Satuan', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="failed">Failed Insert New Satuan!</div>');
            $this->load->view('templates/master_header');
            $this->load->view('superadmin/masterbarang/create');
            $this->load->view('templates/master_footer');
        } else {
            $this->Satuan_model->CreateSatuan();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Insert New Satuan!</div>');
            redirect('masterbarang/modalsatuan');
        }
    }

    public function modalsatuan()
    {
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['satuan'] = $this->Satuan_model->getAllSatuan();
        $data['kategori'] = $this->Kategori_model->getAllKategori();

        $this->load->view('templates/master_header');
        $this->load->view('superadmin/masterbarang/create_modal', $data);
        $this->load->view('templates/master_footer');
    }

    public function modalstore()
    {
        $this->Satuan_model->ModalSatuan();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Insert New Barang!</div>');
        redirect('masterbarang/createsatuan');
    }

    public function edit($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['mbarang'] = $this->Masterbarang_model->getMasterbarangById($id);
        $data['satuan'] = $this->Satuan_model->getAllSatuan();
        $data['kategori'] = $this->Kategori_model->getAllKategori();

        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('nomor_serial', 'Nomor Serial', 'trim|required');
        $this->form_validation->set_rules('nomor_produk', 'Nomor Produk', 'trim|required');
        $this->form_validation->set_rules('batas', 'Batas Peringatan', 'trim|required|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/master_header');
            $this->load->view('superadmin/masterbarang/edit', $data);
            $this->load->view('templates/master_footer');
        } else {
            $this->Masterbarang_model->EditMasterbarang();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Edit Barang!</div>');
            redirect('masterbarang/index');
        }
    }

    public function delete($id)
    {
        $this->Masterbarang_model->HapusMasterBarang($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Success Delete Barang!</div>');
        redirect('masterbarang/index');
    }

    public function process_seldel()
    {
        if (isset($_POST['data'])) {
            $dataArr = $_POST['data'];

            foreach ($dataArr as $id) {
                $this->db->query("DELETE FROM mbarang WHERE id='$id' ");
            }
            echo 'record deleted success';
        }
    }
}
