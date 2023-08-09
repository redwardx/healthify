<?php
session_start();
if(!isset($_SESSION['email'])){
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}
include('connections/localhost.php');

?>

<?php include("includes/header.php"); ?>


<?php include("includes/navbar.php"); ?>

<body>
<div class="container py-5">
	<h2 class="h-auto py-3">Keranjang</h2>
	<?php
	
	$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] );
	$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	$qty =  mysqli_query($conn, "SELECT sum(quantity) as total FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC") or die(mysqli_error($conn));
	$data=mysqli_fetch_assoc($qty);
	
	if ($data['total'] == 0) exit('<p align="center"> Your Cart is Empty</p>'); 
	
	?>
	<div class="row mb-3">
		<div class="col-7">
			<div class="container-grid">
					<?php
					global $totalCost;
					$totalCost = 0;
					while ($row = mysqli_fetch_array($result)) {
						$totalCost = $totalCost + (int)$row['price']*(int)$row['quantity'];
					?>
						<div class="card m-3" style="width: 18rem;">
							<!-- START OF single item box -->
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
						<!-- END OF single item box -->
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
	<?php include("includes/footer.php"); ?>