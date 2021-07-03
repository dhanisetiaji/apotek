<?php
    session_start();
    error_reporting(0);
    include('./include/koneksi.php');
    if(strlen($_SESSION['posisi'])==0){
    header('location:index.php');
    }
    if($_SESSION['posisi']!="Admin"){
    ?> <script language="JavaScript">alert('Anda tidak memiliki akses');</script>
    <a href="dashboard.php">Go Back</a>
        <?php
        // header('Location:./dashboard.php');
    }
    else{
        $sql = "select max(id_kat) as kodeTerbesar FROM kategori";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetch();
        $kodeBarang = $results["kodeTerbesar"];
        $kodeBarang++;
        // $urutan = (int) substr($kodeBarang, 3, 3);
        // $urutan++;
        // $huruf = "BRG";
        // $kodeBarang = $huruf . sprintf("%03s", $urutan);
        // echo $kodeBarang;
        // var_dump($kodeBarang);
        // die();

        if(isset($_GET['del'])){
            $id=$_GET['del'];
            $sql = "delete from kategori  WHERE id_kat=:id";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':id',$id, PDO::PARAM_STR);
            $query -> execute();
          }
        if(isset($_POST['tambah'])){
            $nama_kategori = $_POST['nama_kategori'];
            $id= $kodeBarang;
            $qtambah = "INSERT INTO kategori(id_kat,nama_kategori) VALUES(:id,:nama_kategori)";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':nama_kategori',$nama_kategori, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Kategori Berhasil di tambah!!";
        }
        if(isset($_POST['update'])){
            $id = $_POST['id'];
            $nama_kategori = $_POST['nama_kategori'];
            $qtambah = "UPDATE kategori SET nama_kategori=:nama_kategori WHERE id_kat=:id";
            $tambah = $dbh->prepare($qtambah);
            $tambah -> bindParam(':id',$id, PDO::PARAM_STR);
            $tambah -> bindParam(':nama_kategori',$nama_kategori, PDO::PARAM_STR);
            $tambah -> execute();
            $msg = "Kategori Berhasil di update!!";
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apotek | Kategori</title>
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
            <h1 class="m-0">Menu Kategori</h1>
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
              <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Addkategori"><i class="fas fa-plus"></i> Tambah Kategori</a><br>
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
                    <th>Nama Kategori</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                        
                        $sql = "select * from kategori";
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
                    <td><?php echo htmlentities($res->nama_kategori);?></td>
                    <td>
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#MyModal<?php echo $res->id_kat;?>"><i class="fas fa-edit"></i></a>
                         <a href="kategori.php?del=<?php echo $res->id_kat;?>" onclick="return confirm('Do you want to delete');" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <div class="modal fade" id="MyModal<?php echo $res->id_kat;?>">
                    <div class="modal-dialog" >
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Update Kategori!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                        <div class="form-group">
                                            <label for="">Nama Kategori</label>
                                            <input type="hidden" name="id" value="<?php echo $res->id_kat;?>" class="form-control" required>
                                            <input type="text" name="nama_kategori" value="<?php echo $res->nama_kategori;?>" class="form-control" required>
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
                  <h4 class="modal-title">Tambah Kategori!</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="">
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control" required>
                                <button Type="submit" name="tambah" class="btn btn-primary mt-4">Simpan</button>
                                <button Type="reset" class="btn btn-danger mt-4">Reset</button>
                            </div>
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