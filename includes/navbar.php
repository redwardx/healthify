<?php
include('connections/localhost.php');
?>
<!-- nav bar code-->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Healthify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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

<!-- end of nav bar-->