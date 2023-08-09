<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}								//jika belum, redirect
if(!isset($_SESSION['user'])){  //cek sesi apakah bukan user
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}								//jika bukan, redirect
?>
<!-- memanggil template dari folder include-->
<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>
<!-------------------------------------------->

<div class="container py-5">
	<h2 class="h-auto py-3">Keranjang</h2>
	<?php
	
	$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] ); //mendefinisikan variabel baru dengan mengambil data email dari session
	$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC"; //mendapatkan data dari tabel cart yang dimiliki oleh user dengan email yang sama dengan customer email
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	$qty =  mysqli_query($conn, "SELECT sum(quantity) as total FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC") or die(mysqli_error($conn));
	//menjumlahkan total record dari quantity
	$data=mysqli_fetch_assoc($qty);
	
	if ($data['total'] == 0) exit('<p>Keranjang anda masih kosong, <a href="categories.php">belanja sekarang</a></p>');
	//jika total record dari quantity adalah 0, maka akan muncul kalimat
	
	?>
	<div class="row mb-3">
		<div class="col-7">
			<div class="container-grid">
					<?php
					global $totalCost; //membuat variabel totalcost yang bersifat publik
					$totalCost = 0; 	//dengan nilai awal 0
					while ($row = mysqli_fetch_array($result)) { //mengambil hasil dari result dan menjadikannya array dengan menggunakan variabel row
						$totalCost = $totalCost + (int)$row['price']*(int)$row['quantity']; //mengubah nilai dari totalcost dengan mengambil nilai dari price * qty keseluruhan
					?>
						<div class="card m-3" style="width: 18rem;">
							<img src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>" class="card-img-top" width="200" height="200">
							<div class="card-body">
								<h5 class="card-title"><?php echo $row['productname'] ?></h5>
								<form method="post" action="quantity.php?id=<?php echo $row['cart_id'] ?>">
								<div class="input-group mb-3">
									<span class="input-group-text">Qty.</span>
									<input type="number" name="quantity" value="<?php echo $row['quantity'] ?>" class="form-control" placeholder="Quantity" aria-describedby="button-addon2">
									<button class="btn btn-outline-secondary" type="submit" name="submit">Ubah</button>
								</div>
								</form>
								<p class="card-text"><?php echo "Rp. " . $row['price']*$row['quantity'] ?></p>
							</div>	
						</div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="col-4">
			<div class="card">
				<h5 class="card-header">Detail Pesanan</h5>
				<div class="card-body">
					<h5 class="card-title">Total = Rp.  <?php echo $totalCost ."</h5>"  ?>
					<p class="card-text">Jumlah Barang : <?php echo $data['total'] ."</p>" ?>
					<a href="checkout.php" class="btn btn-primary">Checkout</a></p>
				</div>
			</div>
		</div>
		<?php $_SESSION['totalCost'] = $totalCost; ?>
</div>
<!-- memanggil template dari folder include-->
	<?php include("includes/footer.php"); ?>
<!-------------------------------------------->