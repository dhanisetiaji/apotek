<?php
    session_start();
    error_reporting(0);
    include('./include/koneksi.php');
    if(strlen($_SESSION['posisi'])==0){
    header('location:index.php');
    }
    if($_SESSION['posisi']!="Admin" && $_SESSION['posisi']!="Super Admin"){
    ?> <script language="JavaScript">alert('Anda tidak memiliki akses');</script>
    <a href="dashboard.php">Go Back</a>
        <?php
        // header('Location:./dashboard.php');
    }
    else{
        
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apotek | Print Barang Keluar</title>
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
<body>
      <div class="row">
            <div class="col">
                <div class="card card-secondary">
                  <div class="card-header">
                        <h3 class="card-title">Detail Barang Keluar</h3>
                  </div>
                  <div class="card-body">
                    <?php
                      $id=$_GET['id'];
                      $ret="SELECT * from detail_barang_masuk where id_detail=:id";
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
                            <label for="">ID Barang Masuk</label>
                            <input type="text" value="<?= $result->id_barang_masuk; ?>"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ID Barang</label>
                            <input type="text" value="<?= $result->id_barang; ?>"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="text" value="<?= $result->jumlah; ?>"  class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Harga Beli</label>
                            <input type="text"  value="<?= $result->harga_beli; ?>"class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Expired</label>
                            <input type="date"  value="<?= $result->expired; ?>"class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <?php $nmr=$nmr+1;} };?>
                  </div>
                </div>
            </div>
        </div>
    <!-- /.content -->
  </div>


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
		window.print();
</script>
</body>
</html>
<?php } ?>