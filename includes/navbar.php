<?php
include('connections/localhost.php');
?>
<!-- nav bar code-->
<nav class="navbar fixed-top navbar-expand-lg navbar-default">
    <div class="container">
        <a class="navbar-brand text-light wow slideInLeft" href="dashboard.php">Healthify</a>
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

<!-- end of nav bar-->



<script type="application/javascript">
	function loginFirst() {
		//this will take non-logged in user to Login Page
		window.alert("Please login first!");
		window.location.replace("login.php");
	}
</script>