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

<!--Khusus dashboard, tidak menggunakan template karena terdapat css custom pada header-->
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Healthify</title>
	<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
	<link href="css/animate.css" rel="stylesheet" />
	<link href="css/custom.css" rel="stylesheet" />
    <link href="css/grid.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand wow slideInLeft" href="dashboard.php">Healthify</a>
        <button class="navbar-toggler wow slideInRight" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 wow slideInRight">
                <li class="nav-item"><a class="nav-link active" href="categories.php">Belanja</a></li>
				<?php
					$email = mysqli_real_escape_string($conn,  $_SESSION['email']);             //mengambil email dari sesi
					$query = "SELECT COUNT(*) AS count FROM `cart` WHERE `customer_email`='$email'";        //menghitung jumlah produk dalam cart
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					$cartCount = (int) mysqli_fetch_assoc($result)["count"];                //mengambil data jumlah produk dari cart user
				?>
				<li class="nav-item"><a class="nav-link active" href="cart.php"><div class="sb-nav-link-icon d-inline"><i class="fas fa-shopping-cart"></i></div>(<?= $cartCount ?>)</a></li>
                <li class="nav-item"><a class="nav-link active" href="logout.php">Logout</a></li>
			</ul>
        </div>
    </div>
</nav>
	<header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <h1 class="masthead-heading mb-0 wow fadeInDown" data-wow-duration="3s">Selamat Datang <?php echo $_SESSION['name']; ?></h1>
                <h2 class="masthead-subheading mb-0 wow fadeInDown" data-wow-duration="3s">di <span class="ffest"> Healthify</span></h2>
                <a class="btn btn-warning btn-xl rounded-pill mt-5 wow slideInLeft" data-wow-duration="2s" href="myorders.php">Lihat Keranjang</a>
            </div>
        </div>
    </header>
    <div class="container mb-5">
        <div class="main text-center mt-5">
            <br>
            <br>
            <h1>Produk <span class="ffest">Terbaru</span></h1>
        </div>          
        <?php
            global $conn;
        
            //mencari produk dimana kategori produk sama dengan kategori parameter
            $query = "SELECT * FROM `products` ORDER BY `productID` DESC LIMIT 12";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

            $count = mysqli_num_rows($result);
            //jika jumlahnya 0, maka
            if ($count == 0) exit("Belum ada produk dalam kategori ini.");
        ?> 
        <div class="container mt-4 d-flex mb-5 container-grid">
			<?php
			while ($row = mysqli_fetch_array($result)) {
			?>
				<div class="cards bg-white m-3" style="width: 18rem;">
					<!-- START OF single item box -->
					<img src="<?php echo basename('uploads/') . "/" .  $row['product_image']; ?>" class="card-img-top" width="200" height="200">
					<div class="card-body text-center p-4">
						<h5 class="fw-bold"><?php echo $row['productname'] ?></h5>
						<p><?php echo "Rp. " . $row['price'] ?></p>
						<a href="productview.php?id=<?php echo $row['productID'] ?>" class="btn btn-outline-primary">Detail Produk</a>
					</div>
				</div>
			<?php
				}
			?>
		</div> 
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- Untuk animasi slide, menggunakan wow js-->
    <script src="js/wow.js"></script>
    <script type="text/javascript">
        var nav = document.querySelector('nav');
      
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 100) {
            	nav.classList.add('bg-dark', 'shadow');
          	} else {
            nav.classList.remove('bg-dark', 'shadow');
            }
		});
    </script>
    <script>
        wow = new WOW(
        {
            animateClass: 'animated',
            offset:       100,
            callback:     function(box) {
            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        }
        );
        wow.init();
    </script>
    <footer class="py-4 bg-dark mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Healthify 2023</div>
        </div>
    </div>
</footer>
    </body>
</html>