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


<div class="container py-5">
	<h2 class="h-auto py-3">Produk dalam kategori <?php echo $_GET['category'] ?></h2>
	<?php
	global $conn;
	if (!isset($_GET['category']) || empty(trim($_GET['category']))) {
		header("location: categories.php");
	} else {

		$category = htmlspecialchars(stripslashes(strip_tags($_GET['category'])));
		$category = mysqli_real_escape_string($conn, $category);
		
		$_SESSION['category'] = $category; // for later use.

		$query = "SELECT * FROM `products` WHERE category = '$category'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

		$count = mysqli_num_rows($result);
		if ($count == 0) exit("Belum ada produk dalam kategori ini."); ?>
		
		<div class="container-grid">
			<?php
			while ($row = mysqli_fetch_array($result)) {
			?>
				<div class="card m-3" style="width: 18rem;">
					<!-- START OF single item box -->
					<img src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>" class="card-img-top" width="200" height="200">
					<div class="card-body">
						<h5 class="card-title"><?php echo "Rp. " . $row['price'] ?></h5>
						<p class="card-text"><?php echo $row['productname'] ?></p>
						<a href="addtocart.php?id=<?php echo $row['productID'] ?>" class="btn btn-primary">Add to Cart</a>
					</div>
				</div>
				<!-- END OF single item box -->
		<?php
			}
		}
		?>
		</div>
		</div>
</div>


		<script type="application/javascript">
			function taketoLogin() {
				//this JS takes someone to Login page if not logged in.
				window.alert("Please login first!");
				window.location.replace("login.php");
			}
		</script>
</br>
</br>
	<?php include("includes/footer.php"); ?>
</body>
</html>