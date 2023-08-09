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
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand wow slideInLeft" href="dashboard.php">Healthify</a>
        <button class="navbar-toggler wow slideInRight" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 wow slideInRight">
                <li class="nav-item"><a class="nav-link active" href="categories.php">Produk</a></li>
				<?php
					if (isset($_SESSION['email'])) {
						// if user is LOGGED IN.
						// if user is LOGGED IN.
						$email = mysqli_real_escape_string($conn,  $_SESSION['email']);
						$query = "SELECT COUNT(*) AS count FROM `cart` WHERE `customer_email`='$email'";
						$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
						$cartCount = (int) mysqli_fetch_assoc($result)["count"];

						echo '<li class="nav-item"><a class="nav-link active" href="logout.php">Logout</a></li>';
				?>
				<li class="nav-item"><a class="nav-link active" href="cart.php"><div class="sb-nav-link-icon d-inline"><i class="fas fa-shopping-cart"></i></div>(<?= $cartCount ?>)</a></li>
				<?php
					} else {
						//if  NOT logged in
						echo '<a href="login.php"><strong>Log In</strong></a>';

						echo '<a class="cart-icon" onClick="loginFirst()"><img src="shopping-cart-icon.png" width="20px" height="20px"><strong>Cart</strong></a>';
					}
				?>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
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
    <?php include("includes/footer.php"); ?>
    </body>
</html>