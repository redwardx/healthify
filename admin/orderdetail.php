<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database

$id = $_GET['order'];
 
$result = mysqli_query($conn, "SELECT * FROM detail_orders INNER JOIN `products` ON detail_orders.product_id = products.productID WHERE order_id=$id");
 
?>


<?php include("template/header.php");?>
<?php include("template/navbar.php");?> 
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
          <div class="card mb-4 mt-4">
                <div class="card-header row">
                    <div class="col-11">
                        <i class="fas fa-table me-1"></i>
                        List Pesanan nomor <?php echo $id ?>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-primary" href="orders.php"><i class="fas fa-arrow-left me-1"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-grid">
                        <?php
                        while($data = mysqli_fetch_array($result)) {
                        ?>
                            <div class="card m-3" style="width: 18rem;">
                                <img src="../<?php echo basename('uploads/') . "/" .  $data['product_image']; ?>" class="card-img-top" width="200" height="200">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['productname'] ?></h5>
                                    <p class="card-text">Qty. <?php echo $data['quantity'] ?></p>
                                </div>	
                            </div>
                    <?php
                        }
                    ?>
                </div>
                </div>
            </div>
        </div>
    </main>
<?php include("template/footer.php");?> 