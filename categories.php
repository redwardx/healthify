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

<?php
    $query = "SELECT * FROM `categories`"; //mengambil data dari kategori
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));	
?>
<div class="container py-5">
	<div class="py-3">
		<?php
			//untuk setiap data dalam kategori, program akan melakukan print yang berisikan kode html
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