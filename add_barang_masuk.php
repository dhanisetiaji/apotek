<?php
    session_start();
    error_reporting(0);
    include('./include/koneksi.php');
    if(strlen($_SESSION['posisi'])==0){
    header('location:index.php');
    }
    if($_SESSION['posisi']!="Admin" && $_SESSION['posisi']!="Karyawan"){
    ?> <script language="JavaScript">alert('Anda tidak memiliki akses');</script>
    <a href="dashboard.php">Go Back</a>
        <?php
        // header('Location:./dashboard.php');
    }
    else{
        $sql = "select max(id_barang_masuk) as kodeTerbesar FROM detail_barang_masuk";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetch();
        $kodeBarang = $results["kodeTerbesar"];
        // $kodeBarang++;
        $urutan = (int) substr($kodeBarang, 4, 4);
        $urutan++;
        $huruf = "BM";
        $kodeBarang = $huruf . sprintf("%04s", $urutan);
        // echo $kodeBarang;
        // var_dump($kodeBarang);
        // die();
        $id= $kodeBarang;
        $id_barang_masuk= $id;
        if(isset($_POST['tambah'])){
            // var_dump($_POST);
            // var_dump($id);
            // die();
            $id_barang = $_POST['id_barang'];
            $jumlah = $_POST['jumlah'];
            $harga_beli = $_POST['harga_beli'];
            $expired = $_POST['expired'];
            $query = "INSERT INTO detail_barang_masuk(id_barang_masuk,id_barang,jumlah,harga_beli,expired) VALUES(:id_barang_masuk,:id_barang,:jumlah,:harga_beli,:expired)";
            $tambah = $dbh->prepare($query);
            $tambah -> bindParam(':id_barang_masuk',$id_barang_masuk, PDO::PARAM_STR);
            $index = 0; // Set index array awal dengan 0
            $total1 = 0;
            foreach($id_barang as $id_bar){
              $tambah -> bindParam(':id_barang',$id_bar, PDO::PARAM_STR);
              $tambah -> bindParam(':jumlah',$jumlah[$index], PDO::PARAM_STR);
              $tambah -> bindParam(':harga_beli',$harga_beli[$index], PDO::PARAM_STR);
              $tambah -> bindParam(':expired',$expired[$index], PDO::PARAM_STR);
              $tambah -> execute();
              $total1 += $jumlah[$index]*$harga_beli[$index];
              $index++;
            }
            $id_supplier = $_POST['id_supplier'];
            $id_pegawai = $_POST['id_pegawai'];
            $no_faktur = $_POST['no_faktur'];
            $po_number = $_POST['po_number'];
            $salesman = $_POST['salesman'];
            $tgl = $_POST['tgl'];
            $diskon = $_POST['diskon'];
            $disk=$diskon/100;
            $total2 = $total1*$disk;
            $total = $total1-$total2;
            // $total_harga = $_POST['total_harga'];
            $total_harga = $total;
            $payment_term = $_POST['payment_term'];
            $qtambah = "INSERT INTO barang_masuk(id,id_supplier,id_pegawai,no_faktur,po_number,salesman,tgl,diskon,total_harga,payment_term) VALUES(:id,:id_supplier,:id_pegawai,:no_faktur,:po_number,:salesman,:tgl,:diskon,:total_harga,:payment_term)";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':id_supplier',$id_supplier, PDO::PARAM_STR);
            $tambah -> bindParam(':id_pegawai',$id_pegawai, PDO::PARAM_STR);
            $tambah -> bindParam(':no_faktur',$no_faktur, PDO::PARAM_STR);
            $tambah -> bindParam(':po_number',$po_number, PDO::PARAM_STR);
            $tambah -> bindParam(':salesman',$salesman, PDO::PARAM_STR);
            $tambah -> bindParam(':tgl',$tgl, PDO::PARAM_STR);
            $tambah -> bindParam(':diskon',$diskon, PDO::PARAM_STR);
            $tambah -> bindParam(':total_harga',$total_harga, PDO::PARAM_STR);
            $tambah -> bindParam(':payment_term',$payment_term, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Barang Masuk Berhasil di tambah!";
            // $lastInsertId = $dbh->lastInsertId();
            // if($lastInsertId){
            //     $msg = "Barang Masuk Berhasil di tambah!";
            // }
            // else {
            //     $error="Terjadi kesalahan. Coba lagi!";
            // }
            
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apotek | Add Barang Masuk</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/chosen.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php include('./include/sidebar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Menu Barang Masuk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <?php if($error){?><div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo htmlentities($error); ?> </div><?php } 
                            else if($msg){?><div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo htmlentities($msg); ?> </div><?php }?>
            <div class="row">
              <div class="col">
                  <div class="card card-default">
                      <div class="card-header">
                          <h3 class="card-title">Detail Barang Masuk <button type="button" class="btn btn-sm btn-secondary" id="btn-tambah-form"><i class="nav-icon fas fa-plus"></i> Tambah Data Form</button> <button type="button" class="btn btn-sm btn-danger" id="btn-reset-form">Reset Form</button></h3>
                          <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                          </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                      <b>Data 1 :</b>
                        <form action="" method="post" onSubmit="return valid();" enctype="multipart/form-data">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">ID Barang</label>
                                          <select name="id_barang[]" class="form-control" required>
                                              <option disabled selected>--Pilih--</option>
                                              <?php 
                          
                                                  $sql = "SELECT id from obat_alkes";
                                                  $query = $dbh -> prepare($sql);
                                                  $query->execute();
                                                  $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                  $nmr=1;
                                                  // $ket = array();
                                                  if($query->rowCount() > 0){
                                                      foreach($results as $ress){                  
                                              ?>
                                              <option value="<?= $ress->id?>"><?= $ress->id?></option>
                                              <?php } };?>
                                          </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Jumlah</label>
                                      <input type="number" id="jumlah" name="jumlah[]" class="form-control" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Harga Beli</label>
                                      <input type="number" name="harga_beli[]" id="harga_beli" class="form-control" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Expired</label>
                                      <input type="date" id="expired" name="expired[]" min="2021-06-30" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                          <div id="insert-form"></div>
                          
                          <!-- /.row -->
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Tambah Barang Masuk</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Pegawai</label>
                                <input type="hidden" name="id_pegawai" value="<?= $_SESSION['id']?>" class="form-control" required>
                                <input type="text" value="<?= $_SESSION['nama']?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Supplier</label>
                                    <select name="id_supplier" class="form-control" required>
                                        <option>--Pilih--</option>
                                        <?php 
                    
                                            $sql = "SELECT id,nama_supplier from supplier";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $nmr=1;
                                            // $ket = array();
                                            if($query->rowCount() > 0){
                                                foreach($results as $ress){                  
                                        ?>
                                        <option value="<?= $ress->id?>"><?= $ress->nama_supplier?></option>
                                        <?php } };?>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Faktur</label>
                                <input type="text" name="no_faktur" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">PO Number</label>
                                <input type="text" name="po_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Salesman</label>
                                <input type="text" name="salesman" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Payment Term</label>
                                        <input type="date" name="payment_term" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Diskon</label>
                                <input type="number" min="0" max="100"  name="diskon" id="diskon" class="form-control" placeholder="0-100" required>
                            </div>
                            <!-- <div class="form-group">
                                <label for="">Total Harga</label>
                                <input type="text" id="total_harga" name="total_harga" class="form-control" readonly>
                            </div> -->
                            <button Type="submit" name="tambah" class="btn btn-primary mt-4">Simpan</button>
                            <button Type="reset" class="btn btn-danger mt-4">Reset</button>
                        </div>
                      </div>
                      </form>
                      <input type="hidden" id="jumlah-form" value="1">
                    <!-- /.row -->
                </div>
              </div>
            </div>
            </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="plugins/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){ // Ketika halaman sudah diload dan siap
		$("#btn-tambah-form").click(function(){ // Ketika tombol Tambah Data Form di klik
			var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
			var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
			
			// Kita akan menambahkan form dengan menggunakan append
			// pada sebuah tag div yg kita beri id insert-form
			$("#insert-form").append("<b>Data ke " + nextform + " :</b>" + 
      "<div class='row'><div class='col-md-6'>" + 
      "<div class='form-group'><label>ID Barang</label><input type='text' name='id_barang[]' class='form-control' required></div>" +
      "<div class='form-group'><label>Jumlah</label><input type='number' id='jumlah[]' name='jumlah[]' class='form-control' required></div>"+
      "</div><div class='col-md-6'>"+
      "<div class='form-group'><label>Harga Beli</label><input type='number' name='harga_beli[]' id='harga_beli[]' class='form-control' required></div>" +
      "<div class='form-group'><label>Expired</label><input type='date' id='expired' name='expired[]' min='2021-06-30' class='form-control' required></div>"+
      "</div></div>"
				);
			
			$("#jumlah-form").val(nextform); // Ubah value textbox jumlah-form dengan variabel nextform
      // $('#diskon').on("input",function(){
      //         var jumlah=$('#jumlah').val();
      //         var harga_beli=$('#harga_beli').val();
      //         var diskon1=$('#diskon').val();
      //         var total = 0;
      //         console.log(nextform);
      //         for(var i = 0; i <nextform; i++){
      //             total = jumlah[i]*harga_beli[i];
      //             // console.log(jumlah[i]);
      //             // console.log(harga_beli[i]);
      //             total++;
      //         }
      //         console.log(total);
      //         var diskon=diskon1/100;
      //         var jumdiskon = diskon*total;
      //         var total1 = total-jumdiskon;
      //         $('#total_harga').val(total1);
      //       });

		});
		
		// Buat fungsi untuk mereset form ke semula
		$("#btn-reset-form").click(function(){
			$("#insert-form").html(""); // Kita kosongkan isi dari div insert-form
			$("#jumlah-form").val("1"); // Ubah kembali value jumlah form menjadi 1
		});

	});
	</script>

<!-- <script type="text/javascript">
        $('document').ready(function(){
            $(".chosen-select").chosen();
        })
        $(function(){
            $('#diskon').on("input",function(){
              var jumlah=$('#jumlah').val();
              var harga_beli=$('#harga_beli').val();
              var diskon1=$('#diskon').val();
              var total = 0;
              console.log(jumlah);
              for(var i = 0; i <jumlah.length; i++){
                  total = jumlah[i]*harga_beli[i];
                  // console.log(jumlah[i]);
                  // console.log(harga_beli[i]);
                  total++;
              }
              console.log(total);
              var diskon=diskon1/100;
              var jumdiskon = diskon*total;
              var total1 = total-jumdiskon;
              $('#total_harga').val(total1);
            });
        });
</script> -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
</body>
</html>
<?php } ?>