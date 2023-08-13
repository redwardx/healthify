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
	<h2 class="h-auto py-3">Produk dalam kategori <?php echo $_GET['category'] ?></h2>
	<?php
	global $conn;
	//karena yang ditampilkan per kategori
	if (!isset($_GET['category']) || empty(trim($_GET['category']))) {
		//jika url kategori tidak memiliki parameter, kembali ke page kategori
		header("location: categories.php");
	} else {
		//jika url kategori memiliki parameter
		$category = htmlspecialchars(stripslashes(strip_tags($_GET['category'])));
		$category = mysqli_real_escape_string($conn, $category);
		
		$_SESSION['category'] = $category; // mengambil parameter tersebut kedalam variabel
		
		//mencari produk dimana kategori produk sama dengan kategori parameter
		$query = "SELECT * FROM `products` WHERE category = '$category'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

		//memeriksa jumlah produk dalam kategori
		$count = mysqli_num_rows($result);
		//jika jumlahnya 0, maka
		if ($count == 0) exit("Belum ada produk dalam kategori ini."); ?>

		<div class="container-grid">
			<?php
			//jika ada produk dalam kategori
			while ($row = mysqli_fetch_array($result)) {
			?>
				<div class="card m-3" style="width: 18rem;">
					<!-- START OF single item box -->
					<img src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>" class="card-img-top" width="200" height="200">
					<div class="card-body">
						<h5 class="card-title"><?php echo "Rp. " . $row['price'] ?></h5>
						<p class="card-text"><?php echo $row['productname'] ?></p>
						<a href="productview.php?id=<?php echo $row['productID'] ?>" class="btn btn-primary">Detail Produk</a>
					</div>
				</div>
			<?php
				}
			}
			?>
		</div>
</div>
	<?php include("includes/footer.php"); ?>