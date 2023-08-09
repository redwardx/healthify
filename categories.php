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

<?php include( "includes/header.php" ); ?>

<?php include( "includes/navbar.php" ); ?>
<body>
<?php
    $query = "SELECT * FROM `categories`";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>
<div class="container py-5">
	<div class="py-3">
		<?php
			foreach ($result as $row){
				echo "<div class='card mt-3 mb-5 bg-warning'><div class='card-body'>
					<h5 class='card-title'>${row['category_name']}</h5>
					<p class='card-text'>${row['description']}</p>
					<a href='product.php?category=${row['category_name']}' class='btn btn-dark'>Lihat Produk</a>
				</div>
			</div>";
			}
		?>
	</div>
</div>

<?php include( "includes/footer.php" ); ?>