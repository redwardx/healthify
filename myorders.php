<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}								//jika belum, redirect
if(!isset($_SESSION['user'])){  //cek sesi apakah bukan user
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}								//jika bukan, redirect
include('connections/localhost.php');
?>

<!-- memanggil template dari folder include-->
<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>
<!-------------------------------------------->

<div class="container py-5">
	<h2 class="h-auto py-3">Pesanan Saya</h2>
	<?php
	
	$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] ); //mengambil email
	//mengambil data orders yang dimiliki oleh customer
	$query = "SELECT * FROM `orders` INNER JOIN `products` ON orders.product_id = products.productID AND orders.customer_email = '$customeremail' ORDER BY `date_added` DESC";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	//menghitung jumlah orders
	$count = mysqli_num_rows($result);
	//jika orders 0, maka akan muncul pesan
	if ($count == 0) exit('<p align="center"> Kamu belum meiliki pesanan </p>'); 
	
	?>
	<div class="container-down">
			<?php
			while ($row = mysqli_fetch_array($result)) {
			?>
				<div class="card m-3" style="width: 18rem;">
					<img src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>" class="card-img-top" width="200" height="200">
					<div class="card-body">
						<h5 class="card-title"><?php echo $row['productname'] ?></h5>
						<h6 class="card-subtitle mb-2 text-body-secondary"><?php echo "Rp. " . $row['price'] ?></h6>
    					<p class="card-text">Tanggal Pemesanan:  <?php echo date_format(new DateTime($row['date_added']), "Y-M-d H:i")  ?></p>
					</div>
				</div>
		<?php
			}
		?>
		</div>
		<br> 
		<hr>

		<hr>
</br>
</br>
	<?php include("includes/footer.php"); ?>
</body>
</html>