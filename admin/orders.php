<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database
?>

<?php include("template/header.php");?>
<?php include("template/navbar.php");?> 
  <div id="layoutSidenav_content">
      <main>
          <div class="container-fluid px-4">
          <h1 class="mt-4">Pesanan</h1>
          <?php
            $query = "SELECT * FROM `orders` INNER JOIN `products` ON orders.product_id = products.productID ORDER BY `date_added` DESC";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          ?>
          <div class="card mb-4">
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th scope="col">Order #</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah Dibayarkan (Rp.)</th>
                    <th scope="col">Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    global $i; 
                      $i = 0; //dummy variabel untuk membuat nomor secara urut
                    while ($row = mysqli_fetch_array($result)) {
                      $i = ++$i ;
                  ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['customer_email'] ?></td>
                    <td><?php echo $row['productname'] ?></td>
                    <td align="center"><?php echo $row['price'] ?></td>
                    <td><?php echo date_format(new DateTime($row['date_added']), "Y-M-d H:i")  ?></td>
                  </tr>
                  <?php  }	?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
      </main>
<?php include("template/footer.php");?> 
