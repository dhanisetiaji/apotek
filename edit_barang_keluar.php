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
        if(isset($_GET['del'])){
            $id=$_GET['del'];
            $sql = "delete from detail_barang_keluar  WHERE id_detail=:id";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':id',$id, PDO::PARAM_STR);
            $query -> execute();
            header('Location:./barang_keluar.php');
          }
        $id= $_GET['id'];
        $id_barang_keluar= $id;
        if(isset($_POST['update'])){
            // var_dump($_POST);
            // var_dump($id);
            // die();
            #
            $id_detail= $_POST['id_detail'];
            $id_barang = $_POST['id_barang'];
            $id_supplier = $_POST['id_supplier'];
            $jumlah = $_POST['jumlah'];
            $harga_beli = $_POST['harga_beli'];
            $expired = $_POST['expired'];
            $query = "UPDATE detail_barang_keluar SET id_barang_keluar=:id_barang_keluar,id_barang=:id_barang,id_supplier=:id_supplier,jumlah=:jumlah,harga_beli=:harga_beli,expired=:expired WHERE id_detail=:id_detail";
            $tambah = $dbh->prepare($query);
            $tambah -> bindParam(':id_barang_keluar',$id_barang_keluar, PDO::PARAM_STR);
            $total = 0;
            $index = 0;
            foreach($id_detail as $id_det){
                $tambah -> bindParam(':id_detail',$id_det, PDO::PARAM_STR);
                $tambah -> bindParam(':id_supplier',$id_supplier[$index], PDO::PARAM_STR);
                $tambah -> bindParam(':id_barang',$id_barang[$index], PDO::PARAM_STR);
                $tambah -> bindParam(':jumlah',$jumlah[$index], PDO::PARAM_STR);
                $tambah -> bindParam(':harga_beli',$harga_beli[$index], PDO::PARAM_STR);
                $tambah -> bindParam(':expired',$expired[$index], PDO::PARAM_STR);
                $tambah -> execute();
                $total += $harga_beli[$index]*$jumlah[$index];
                $index++;
            }
            $id_pegawai = $_POST['id_pegawai'];
            $tgl = $_POST['tgl'];
            // $total_harga = $_POST['total_harga'];
            $total_harga = $total;
            $qtambah = "UPDATE barang_keluar SET id_pegawai=:id_pegawai,tgl=:tgl,total_harga=:total_harga WHERE id=:id";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':id_pegawai',$id_pegawai, PDO::PARAM_STR);
            $tambah -> bindParam(':tgl',$tgl, PDO::PARAM_STR);
            $tambah -> bindParam(':total_harga',$total_harga, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Barang Keluar Berhasil di Update!";
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
  <title>Apotek | Edit Barang Keluar</title>
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
            <h1 class="m-0">Menu Edit Barang Keluar</h1>
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
                        <h3 class="card-title">Detail Barang Keluar </h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <form action="" method="post" onSubmit="return valid();" enctype="multipart/form-data">
                        <?php
                          $id=$_GET['id'];
                          $ret="select * from detail_barang_keluar WHERE id_barang_keluar=:id";
                          $query= $dbh -> prepare($ret);
                          $query->bindParam(':id',$id, PDO::PARAM_STR);
                          $query-> execute();
                          $results = $query -> fetchAll(PDO::FETCH_OBJ);
                          // var_dump($results);
                          // die();
                          $nmr=1;
                          if($query -> rowCount() > 0){
                              foreach($results as $result){
                        ?>
                        <b>Data <?= $nmr;?>:</b>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Barang</label>
                                        <select name="id_barang[]" class="form-control" required>
                                            <?php	
                                                $id=$result->id_barang;
                                                $que="select id,nama from obat_alkes where id=:id";
                                                $query1= $dbh -> prepare($que);
                                                $query1->bindParam(':id',$id, PDO::PARAM_STR);
                                                $query1-> execute();
                                                $results = $query1 -> fetchAll(PDO::FETCH_OBJ);
                                                // var_dump($results);
                                                // die();
                                                if($query1 -> rowCount() > 0){
                                                    foreach($results as $q){
                                            ?>
                                            <option value="<?= $result->id_barang;?>">--<?= $q->nama;?>--</option>
                                            <?php }} ?>
                                            <?php 
                        
                                                $sql = "SELECT id from obat_alkes";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0){
                                                    foreach($results as $ress){                  
                                            ?>
                                            <option value="<?= $ress->id?>"><?= $ress->id?></option>
                                            <?php } };?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier</label>
                                        <select name="id_supplier[]" class="form-control" required>
                                            <?php	
                                                $id=$result->id_supplier;
                                                $que="select id,nama_supplier from supplier where id=:id";
                                                $query1= $dbh -> prepare($que);
                                                $query1->bindParam(':id',$id, PDO::PARAM_STR);
                                                $query1-> execute();
                                                $results = $query1 -> fetchAll(PDO::FETCH_OBJ);
                                                // var_dump($results);
                                                // die();
                                                if($query1 -> rowCount() > 0){
                                                    foreach($results as $q){
                                            ?>
                                            <option value="<?= $result->id_supplier; ?>">--<?= $q->nama_supplier; ?>--</option>
                                            <?php }} ?>
                                            <?php 
                        
                                                $sql = "SELECT id,nama_supplier from supplier";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0){
                                                    foreach($results as $ress){                  
                                            ?>
                                            <option value="<?= $ress->id?>"><?= $ress->nama_supplier?></option>
                                            <?php } };?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah</label>
                                    <input type="number" id="jumlah" value="<?= $result->jumlah; ?>" name="jumlah[]" class="form-control" required>
                                    <input type="hidden"  value="<?= $result->id_detail; ?>" name="id_detail[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Harga Beli</label>
                                    <input type="number" name="harga_beli[]" value="<?= $result->harga_beli; ?>" id="harga_beli" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Expired</label>
                                    <input type="date" id="expired" name="expired[]" value="<?= $result->expired; ?>" min="2021-06-30" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <a href="edit_barang_keluar.php?del=<?php echo $result->id_detail;?>" onclick="return confirm('Do you want to delete');" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                </div>

                            </div>
                        </div>
                        <?php $nmr=$nmr+1;}} ?>
                        <!-- <div id="insert-form"></div> -->
                        
                        <!-- /.row -->
                  </div>
                </div>
              </div>
            </div>
      <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Edit Barang Keluar</h3>
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
                            <?php	
                                $id=$_GET['id'];
                                $ret="select * from barang_keluar WHERE id=:id";
                                $query= $dbh -> prepare($ret);
                                $query->bindParam(':id',$id, PDO::PARAM_STR);
                                $query-> execute();
                                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                // var_dump($results);
                                // die();
                                if($query -> rowCount() > 0){
                                    foreach($results as $result){
                            ?>
                            <div class="form-group">
                                <label for="">ID Pegawai</label>
                                <input type="hidden" name="id_pegawai" value="<?= $_SESSION['id']?>" class="form-control" required>
                                <input type="text" value="<?= $result->id_pegawai;?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" value="<?= $result->tgl; ?>" name="tgl" class="form-control" required>
                            </div>
                            <button Type="submit" name="update" class="btn btn-primary mt-4">Update</button>
                        </div>
                    </div>
                    <?php }} ?>
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
			$("#insert-form").append("<b>Tambah Baru :</b>" + 
      "<div class='row'><div class='col-md-6'>" + 
      "<div class='form-group'><label>ID Barang</label><input type='text' name='id_barang[]' class='form-control' required></div>" +
      "<div class='form-group'><label>Jumlah</label><input type='number' id='jumlah[]' name='jumlah[]' class='form-control' required></div>"+
      "<div class='form-group'><label>ID Supplier</label><input type='text' name='id_supplier[]' class='form-control' required></div>"+
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
</body>
</html>
<?php } ?>