<!doctype html>
<html class="fixed">

<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Master Barang | Admin | Inventory Barang</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
    <meta name="author" content="JSOFT.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/css/basic.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/css/dropzone.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/summernote/summernote.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/summernote/summernote-bs3.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/codemirror/theme/monokai.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/theme-custom.css">
    <!-- Head Libs -->
    <script src="<?php echo base_url(); ?>assets/vendor/modernizr/modernizr.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/form.css" />

    <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Sembunyikan alert validasi kosong
            $("#kosong").hide();
        });
    </script>
</head>

<body>
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>

                    <h2 class="panel-title"><b>FORM IMPORT EXCEL</b></h2>
                </header>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <strong>
                            Perhatian! sebelum melakukan <i>"import"</i> harap baca prosedur di bawah ini :
                        </strong>
                        <ul>
                            <li>
                                Pertama, jika ingin melakukan import pastikan template yang diimport harus sama dengan template yang sudah di download
                                melalui "tombol" print pada halaman sebelumnya.
                            </li>
                            <li>
                                Kedua, Jika belum mendownload template pada halaman sebelumnya, anda bisa bisa mendownloadnya pada halaman ini.
                            </li>
                            <li>
                                Ketiga, jika ada kendala melakukan import silahkan hubungi bagian IT.
                            </li>
                        </ul>
                    </div>
                    <section class="panel">
                        <hr>
                        <div class="panel-body">
                            Template Excel : <a style="margin-left: 1%;" href="<?php echo base_url("excel/Master Barang.xlsx"); ?>" class="mb-xs mt-xs mr-xs btn btn-sm btn-default">
                                <i class="fa fa-print"></i>&nbsp;
                                Print
                            </a><b>.xlsx</b>
                            <!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
                            <form method="post" action="<?php echo base_url("masterbarang/form"); ?>" enctype="multipart/form-data">
                                <!-- 
                                -- Buat sebuah input type file
                                -- class pull-left berfungsi 	agar file input berada di sebelah kiri
                                -->
                                <input type="file" name="file" class="mb-xs mt-xs mr-xs btn btn-sm btn-default">

                                <!--
                                -- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
                                -->
                                <br />
                                <input type="submit" name="preview" value="Preview" class="mb-xs mt-xs mr-xs btn btn-sm btn-success">
                                <a href="<?php echo site_url('masterbarang/index'); ?>" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger">Cancel</a>

                            </form>
                            <?php
                            if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form 
                                if (isset($upload_error)) { // Jika proses upload gagal
                                    echo "<div style='color: red;'>" . $upload_error . "</div>"; // Muncul pesan error upload
                                    die; // stop skrip
                                }

                                error_reporting(0);
                                echo "<br />";
                                // Buat sebuah tag form untuk proses import data ke database
                                echo "<form method='post' action='" . base_url("masterbarang/import") . "'>";

                                // Buat sebuah div untuk alert validasi kosong
                                echo "<div style='color: red;' id='kosong'>
                                Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
                                </div>";

                                echo "<table border='1' cellpadding='8'  class='table table-bordered table-striped mb-none' id='datatable-default'>
                                <tr>
                                    <th colspan='10' align='center'>Preview Data</th>
                                </tr>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Kategori</th>
                                    <th>Kondisi Barang</th>
                                    <th>Nomor Serial</th>
                                    <th>Nomor Produk</th>
                                    <th>Keterangan Barang</th>
                                    <th>Batas</th>
                                    <th>Nama Satuan</th>
                                    <th>Photo</th>
                                </tr>";

                                $numrow = 1;
                                $kosong = 0;

                                // Lakukan perulangan dari data yang ada di excel
                                // $sheet adalah variabel yang dikirim dari controller
                                foreach ($sheet as $row) {
                                    // Ambil data pada excel sesuai Kolom
                                    $kode_barang = $row['A']; // Insert data nis dari kolom A di excel
                                    $nama_barang = $row['B']; // Insert data nama dari kolom B di excel
                                    $nama_kategori = $row['C']; // Insert data jenis kelamin dari kolom C di excel
                                    $kondisi_barang = $row['D']; // Insert data alamat dari kolom D di excel
                                    $nomor_serial = $row['E']; // Insert data nis dari kolom A di excel
                                    $nomor_produk = $row['F']; // Insert data nis dari kolom A di excel
                                    $keterangan_barang = $row['G']; // Insert data nis dari kolom A di excel
                                    $batas = $row['H']; // Insert data nis dari kolom A di excel
                                    $nama_satuan = $row['I']; // Insert data nis dari kolom A di excel
                                    $photo = $row['J']; // Insert data nis dari kolom A di excel
                                    if (empty($kode_barang) && empty($nama_barang) && empty($nama_kategori) && empty($kondisi_barang) && empty($nomor_serial) && empty($nomor_produk) && empty($keterangan_barang) && empty($batas) && empty($nama_satuan) && empty($photo))
                                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                    // Cek $numrow apakah lebih dari 1
                                    // Artinya karena baris pertama adalah nama-nama kolom
                                    // Jadi dilewat saja, tidak usah diimport
                                    if ($numrow > 1) {
                                        // Validasi apakah semua data telah diisi
                                        $kode_barang_td = (!empty($kode_barang)) ? "" : " style='background: #E07171;'"; // Jika Kode Barang kosong, beri warna merah
                                        $nama_barang_td = (!empty($nama_barang)) ? "" : " style='background: #E07171;'"; // Jika Nama Barang kosong, beri warna merah
                                        $nama_kategori_td = (!empty($nama_kategori)) ? "" : " style='background: #E07171;'"; // Insert data Nama Kategori dari kolom C di excel
                                        $kondisi_barang_td = (!empty($kondisi_barang)) ? "" : " style='background: #E07171;'"; // Jika Kondisi Barang kosong, beri warna merah
                                        $nomor_serial_td = (!empty($nomor_serial)) ? "" : " style='background: #E07171;'"; // Jika Nomor Serial kosong, beri warna merah
                                        $nomor_produk_td = (!empty($nomor_produk)) ? "" : " style='background: #E07171;'"; // Jika Nomor Produk kosong, beri warna merah
                                        $keterangan_barang_td = (!empty($keterangan_barang)) ? "" : " style='background: #E07171;'"; // Jika Keterangan Barang kosong, beri warna merah
                                        $batas_td = (!empty($batas)) ? "" : " style='background: #E07171;'"; // Jika Batas kosong, beri warna merah
                                        $nama_satuan_td = (!empty($nama_satuan)) ? "" : " style='background: #E07171;'"; // Jika Nama Satuan kosong, beri warna merah
                                        $photo_td = (!empty($photo)) ? "" : " style='background: #E07171;'"; // Jika Photo kosong, beri warna merah

                                        // Jika salah satu data ada yang kosong
                                        if (empty($kode_barang) or empty($nama_barang) or empty($nama_kategori) or empty($kondisi_barang) or empty($nomor_serial) or empty($nomor_produk) or empty($keterangan_barang) or empty($batas) or empty($nama_satuan) or empty($photo)) {
                                            $kosong++; // Tambah 1 variabel $kosong
                                        }

                                        echo "<tr>";
                                        echo "<td" . $kode_barang_td . ">" . $kode_barang . "</td>";
                                        echo "<td" . $nama_barang_td . ">" . $nama_barang . "</td>";
                                        echo "<td" . $nama_kategori_td . ">" . $nama_kategori . "</td>";
                                        echo "<td" . $kondisi_barang_td . ">" . $kondisi_barang . "</td>";
                                        echo "<td" . $nomor_serial_td . ">" . $nomor_serial . "</td>";
                                        echo "<td" . $nomor_produk_td . ">" . $nomor_produk . "</td>";
                                        echo "<td" . $keterangan_barang_td . ">" . $keterangan_barang . "</td>";
                                        echo "<td" . $batas_td . ">" . $batas . "</td>";
                                        echo "<td" . $nama_satuan_td . ">" . $nama_satuan . "</td>";
                                        echo "<td" . $photo_td . ">" . $photo . "</td>";
                                        echo "</tr>";
                                    }

                                    $numrow++; // Tambah 1 setiap kali looping
                                }

                                echo "</table>";

                                // Cek apakah variabel kosong lebih dari 0
                                // Jika lebih dari 0, berarti ada data yang masih kosong
                                if ($kosong > 0) {
                                    ?>
                                    <script>
                                        $(document).ready(function() {
                                            // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                                            $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                                            $("#kosong").show(); // Munculkan alert validasi kosong
                                        });
                                    </script>
                                <?php
                                } else { // Jika semua data sudah diisi
                                    echo "<hr>";

                                    // Buat sebuah tombol untuk mengimport data ke database
                                    echo "<button type='submit' name='import' class='mb-xs mt-xs mr-xs btn btn-sm btn-primary'>Import</button>";
                                    echo "<a href='" . base_url("masterbarang/index") . "' class='mb-xs mt-xs mr-xs btn btn-sm btn-danger'>Cancel</a>";
                                }

                                echo "</form>";
                            }
                            ?>
                        </div>
                    </section>
                </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>/assets/vendor/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <!-- Specific Page Vendor -->
    <script src="<?php echo base_url(); ?>/assets/vendor/pnotify/pnotify.custom.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/select2/select2.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/fuelux/js/spinner.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/dropzone/dropzone.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-markdown/js/markdown.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/lib/codemirror.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/addon/selection/active-line.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/mode/javascript/javascript.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/mode/xml/xml.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/codemirror/mode/css/css.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/summernote/summernote.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/ios7-switch/ios7-switch.js"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo base_url(); ?>/assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="<?php echo base_url(); ?>/assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="<?php echo base_url(); ?>/assets/javascripts/theme.init.js"></script>

    <script src="<?php echo base_url(); ?>/assets/vendor/dropzone/dropzone.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/jquery-autosize/jquery.autosize.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>


    <!-- Examples -->
    <script src="<?php echo base_url(); ?>/assets/javascripts/ui-elements/examples.modals.js"></script>

    <script src="<?php echo base_url(); ?>/assets/javascripts/forms/examples.advanced.form.js" />
    </script>
    <script src="<?php echo base_url(); ?>/assets/javascripts/tables/examples.datatables.default.js"></script>
    <script src="<?php echo base_url(); ?>/assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
    <script src="<?php echo base_url(); ?>/assets/javascripts/tables/examples.datatables.tabletools.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('#delete').click(function() {
                //confirm alert
                var deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm == true) {
                    var dataArr = new Array();
                    if ($('input:checkbox:checked').length > 0) {
                        $('input:checkbox:checked').each(function() {
                            dataArr.push($(this).attr('id'));
                            $(this).closest('tr').remove();
                        });
                        sendResponse(dataArr)
                    } else {
                        alert('No record selected ');
                    }
                }
            });


            function sendResponse(dataArr) {
                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url('masterbarang/process_seldel'); ?>',
                    data: {
                        'data': dataArr
                    },
                    success: function(response) {
                        alert(response);
                        window.location.href = '<?php echo site_url('masterbarang/index'); ?>';
                    },
                    error: function(errResponse) {
                        alert(errResponse);
                        window.location.href = '<?php echo site_url('masterbarang/index'); ?>';
                    }
                });
            }


        });
    </script>
</body>

</html>