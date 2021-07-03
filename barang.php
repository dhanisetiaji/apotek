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
        $sql = "select max(id) as kodeTerbesar FROM obat_alkes";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetch();
        $kodeBarang = $results["kodeTerbesar"];
        $urutan = (int) substr($kodeBarang, 5, 5);
        $urutan++;
        $huruf = "BR";
        $kodeBarang = $huruf . sprintf("%05s", $urutan);
        // echo $kodeBarang;
        // var_dump($kodeBarang);
        // die();

        if(isset($_GET['del'])){
            $id=$_GET['del'];
            $sql = "delete from obat_alkes  WHERE id=:id";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':id',$id, PDO::PARAM_STR);
            $query -> execute();
          }
        if(isset($_POST['tambah'])){
            // var_dump($_POST);
            // die();
            $id= $kodeBarang;
            $id_kategori = $_POST['id_kategori'];
            $nama = $_POST['nama'];
            $satuan = $_POST['satuan'];
            $harga_beli = $_POST['harga_beli'];
            $jumlah = $_POST['jumlah'];
            $stok = $_POST['stok'];
            $dosis = $_POST['dosis'];
            $keterangan = $_POST['keterangan'];
            $qtambah = "INSERT INTO obat_alkes(id,id_kategori,nama,satuan,harga_beli,jumlah,stok,dosis,keterangan) VALUES(:id,:id_kategori,:nama,:satuan,:harga_beli,:jumlah,:stok,:dosis,:keterangan)";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':id_kategori',$id_kategori, PDO::PARAM_STR);
            $tambah -> bindParam(':nama',$nama, PDO::PARAM_STR);
            $tambah -> bindParam(':satuan',$satuan, PDO::PARAM_STR);
            $tambah -> bindParam(':harga_beli',$harga_beli, PDO::PARAM_STR);
            $tambah -> bindParam(':jumlah',$jumlah, PDO::PARAM_STR);
            $tambah -> bindParam(':stok',$stok, PDO::PARAM_STR);
            $tambah -> bindParam(':dosis',$dosis, PDO::PARAM_STR);
            $tambah -> bindParam(':keterangan',$keterangan, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Barang Berhasil di tambah!";
        }
        if(isset($_POST['update'])){
            $id = $_POST['id'];
            $id_kategori = $_POST['id_kategori'];
            $nama = $_POST['nama'];
            $satuan = $_POST['satuan'];
            $harga_beli = $_POST['harga_beli'];
            $jumlah = $_POST['jumlah'];
            $stok = $_POST['stok'];
            $dosis = $_POST['dosis'];
            $keterangan = $_POST['keterangan'];
            $qtambah = "UPDATE obat_alkes SET id_kategori=:id_kategori,nama=:nama,satuan=:satuan,harga_beli=:harga_beli,jumlah=:jumlah,stok=:stok,dosis=:dosis,keterangan=:keterangan WHERE id=:id";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':id_kategori',$id_kategori, PDO::PARAM_STR);
            $tambah -> bindParam(':nama',$nama, PDO::PARAM_STR);
            $tambah -> bindParam(':satuan',$satuan, PDO::PARAM_STR);
            $tambah -> bindParam(':harga_beli',$harga_beli, PDO::PARAM_STR);
            $tambah -> bindParam(':jumlah',$jumlah, PDO::PARAM_STR);
            $tambah -> bindParam(':stok',$stok, PDO::PARAM_STR);
            $tambah -> bindParam(':dosis',$dosis, PDO::PARAM_STR);
            $tambah -> bindParam(':keterangan',$keterangan, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Kategori Berhasil di update!!";
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apotek | Barang</title>
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
            <h1 class="m-0">Menu Barang</h1>
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
      <div class="row">
          <div class="col-12">
          <div class="card">
              <div class="card-header">
              <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Addkategori"><i class="fas fa-plus"></i> Tambah Barang</a><br>
                <?php 
                    if($error){
                ?>
                <br><div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo htmlentities($error); ?> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } 
				    else if($msg){
                ?>
                <br><div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo htmlentities($msg); ?> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php }?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>H Beli</th>
                    <th>Qty</th>
                    <th>Stok</th>
                    <th>Dosis</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                        function rupiah($angka){
	
                            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                            return $hasil_rupiah;
                         
                        }
                        $sql = "SELECT * from obat_alkes INNER JOIN kategori ON obat_alkes.id_kategori=kategori.id_kat";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $nmr=1;
                        // $ket = array();
                        if($query->rowCount() > 0){
                            foreach($results as $res){                  
                    ?>
                  <tr>
                      
                    <td><?php echo htmlentities($nmr);?></td>
                    <td><?php echo htmlentities($res->id);?></td>
                    <td><?php echo htmlentities($res->nama);?></td>
                    <td><?php echo htmlentities($res->nama_kategori);?></td>
                    <td><?php echo htmlentities($res->satuan);?></td>
                    <td><?php echo rupiah($res->harga_beli);?></td>
                    <td><?php echo htmlentities($res->jumlah);?></td>
                    <td><?php echo htmlentities($res->stok);?></td>
                    <td><?php echo htmlentities($res->dosis);?></td>
                    <td><?php
                        $num_char = 30;
                        $text = $res->keterangan;
                        echo substr($text, 0, $num_char) . '...';
                        ?>
                    </td>
                    <td>
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#MyModal<?php echo $res->id;?>"><i class="fas fa-edit"></i></a>
                         <a href="barang.php?del=<?php echo $res->id;?>" onclick="return confirm('Do you want to delete');" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <div class="modal fade" id="MyModal<?php echo $res->id;?>">
                    <div class="modal-dialog" >
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Update Barang!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="hidden" name="id" value="<?php echo $res->id;?>" class="form-control" required>
                                            <input type="text" name="nama" value="<?php echo $res->nama;?>" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select name="id_kategori" class="form-control" required>
                                                        <option value="<?php echo $res->id_kategori;?>">--<?php echo $res->nama_kategori;?>--</option>
                                                        <?php 
                                    
                                                            $sql1 = "SELECT * from kategori";
                                                            $query1 = $dbh -> prepare($sql1);
                                                            $query1->execute();
                                                            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                            $nmr=1;
                                                            // $ket = array();
                                                            if($query1->rowCount() > 0){
                                                                foreach($results1 as $ress){                  
                                                        ?>
                                                        <option value="<?= $ress->id_kat?>"><?= $ress->nama_kategori?></option>
                                                        <?php } };?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Satuan</label>
                                                    <select name="satuan" class="form-control" required>
                                                        <option value="<?php echo $res->satuan;?>">--<?php echo $res->satuan;?>--</option>
                                                        <option value="Strip">Strip</option>
                                                        <option value="Box">Box</option>
                                                        <option value="Botol">Botol</option>
                                                        <option value="Sachet">Sachet</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Harga Beli</label>
                                            <input type="number" value="<?php echo $res->harga_beli;?>" name="harga_beli" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Jumlah</label>
                                                    <input type="number" value="<?php echo $res->jumlah;?>" name="jumlah" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Stok</label>
                                                    <input type="number" name="stok" value="<?php echo $res->stok;?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Dosis</label>
                                                    <input type="text" name="dosis" value="<?php echo $res->dosis;?>" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" rows="3" name="keterangan" placeholder="keterangan"><?php echo $res->keterangan;?></textarea>
                                            <button Type="submit" name="update" class="btn btn-primary mt-4">Update</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                            <?php $nmr=$nmr+1; } } ?>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </div>
                    </div>
        <div class="modal fade" id="Addkategori">
          <div class="modal-dialog" >
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 class="modal-title">Tambah Barang!</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="id_kategori" class="form-control" required>
                                            <option disabled selected>--Pilih--</option>
                                            <?php 
                        
                                                $sql = "SELECT * from kategori";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $nmr=1;
                                                // $ket = array();
                                                if($query->rowCount() > 0){
                                                    foreach($results as $ress){                  
                                            ?>
                                            <option value="<?= $ress->id_kat?>"><?= $ress->nama_kategori?></option>
                                            <?php } };?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Satuan</label>
                                        <select name="satuan" class="form-control" required>
                                            <option>--Pilih--</option>
                                            <option value="Strip">Strip</option>
                                            <option value="Box">Box</option>
                                            <option value="Botol">Botol</option>
                                            <option value="Sachet">Sachet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Beli</label>
                                <input type="number" name="harga_beli" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Dosis</label>
                                        <input type="text" name="dosis" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="3" name="keterangan" placeholder="keterangan"></textarea>
                            </div>
                            <button Type="submit" name="tambah" class="btn btn-primary mt-4">Simpan</button>
                            <button Type="reset" class="btn btn-danger mt-4">Reset</button>

                      </form>
                  </div>
              </div>
              <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
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
<script type="text/javascript">
        $('document').ready(function(){
            $(".chosen-select").chosen();
        })
        $(function(){
            $('#jml_uang').on("input",function(){
                var total=$('#total').val();
                var jumuang=$('#jml_uang').val();
                var hsl=jumuang.replace(/[^\d]/g,"");
                $('#jml_uang2').val(hsl);
                $('#kembalian').val(hsl-total);
            })
            
        });
    </script>
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