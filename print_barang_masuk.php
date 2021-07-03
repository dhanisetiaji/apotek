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
  <title>Apotek | Print Barang Masuk</title>
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
                        <h3 class="card-title">Detail Barang Masuk</h3>
                  </div>
                  <div class="card-body">
                    <?php
                      $id=$_GET['id'];
                      $ret="select * from detail_barang_masuk WHERE id_barang_masuk=:id";
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
                            <input type="text" value="<?= $q->nama;?>" class="form-control" readonly>
                            <?php } };?>
                        </div>
                        <div class="form-group">
                            <label for="">Expired</label>
                            <input type="date" id="expired" name="expired" value="<?= $result->expired; ?>" min="2021-06-30" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Jumlah</label>
                              <input type="number" id="jumlah" value="<?= $result->jumlah; ?>" name="jumlah" class="form-control" readonly>
                          </div>
                          <div class="form-group">
                              <label for="">Harga Beli</label>
                              <input type="number" name="harga_beli" value="<?= $result->harga_beli; ?>" id="harga_beli" class="form-control" readonly>
                          </div>
                      </div>
                    </div>
                    <?php $nmr=$nmr+1;} };?>
                  </div>
                </div>
            </div>
        </div>
        <?php	
            $id=$_GET['id'];
            $ret="select * from barang_masuk WHERE id=:id";
            $query= $dbh -> prepare($ret);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query-> execute();
            $results = $query -> fetchAll(PDO::FETCH_OBJ);
            // var_dump($results);
            // die();
            if($query -> rowCount() > 0){
                foreach($results as $result){
        ?>
        <div class="row">
            <div class="col">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Barang Masuk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Pegawai</label>
                                    <?php	
                                        $id1=$result->id_pegawai;
                                        $que="SELECT id,nama FROM pegawai WHERE id=:id";
                                        $query1= $dbh->prepare($que);
                                        $query1->bindParam(':id',$id1, PDO::PARAM_STR);
                                        $query1-> execute();
                                        $results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
                                        if($query1 -> rowCount() > 0){
                                            foreach($results1 as $res){
                                    ?>
                                    <input type="text" value="<?= $res->nama;?>" class="form-control" readonly>
                                    <?php } };?>
                                </div>
                                <div class="form-group">
                                    <label for="">Supplier</label>
                                    <?php	
                                        $id2=$result->id_supplier;
                                        $que1="SELECT id,nama_supplier from supplier where id=:id";
                                        $query2= $dbh -> prepare($que1);
                                        $query2->bindParam(':id',$id2, PDO::PARAM_STR);
                                        $query2-> execute();
                                        $results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
                                        // var_dump($results);
                                        // die();
                                        if($query2 -> rowCount() > 0){
                                            foreach($results2 as $q){
                                    ?>
                                    <input type="text" value="<?= $q->nama_supplier;?>" class="form-control" readonly>
                                    <?php } };?>
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Faktur</label>
                                    <input type="text" value="<?= $result->no_faktur; ?>" name="no_faktur" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">PO Number</label>
                                    <input type="text" name="po_number" value="<?= $result->po_number; ?>" class="form-control" readonly>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Salesman</label>
                                    <input type="text" name="salesman" value="<?= $result->salesman; ?>" class="form-control" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" value="<?= $result->tgl; ?>" name="tgl" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Payment Term</label>
                                            <input type="date" name="payment_term" value="<?= $result->payment_term; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Diskon</label>
                                    <input type="number" min="0" max="100" value="<?= $result->diskon; ?>"  name="diskon" id="diskon" class="form-control" placeholder="0-100" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Total Harga</label>
                                    <!-- <input type="number" name="total_harga" class="form-control" disabled> -->
                                    <input type="text" id="total_harga" value="<?= $result->total_harga; ?>" name="total_harga" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } };?>

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