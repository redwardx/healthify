<?php
session_start();
if(!isset($_SESSION['email'])){
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}

include("Connections/localhost.php");
global $conn;
if (!isset($_SESSION['email']) || !isset($_SESSION['totalCost']) || (int)$_SESSION['totalCost'] <= 0) {
	//KICK USER OUT OF THIS PAGE
	exit("<script>window.location.replace('categories.php')</script>");
}

$customeremail = mysqli_real_escape_string($conn, $_SESSION['email']);
$totalCost = mysqli_real_escape_string($conn, $_SESSION['totalCost']);

//first select all stuff in Cart Table 
$selectQuery = "SELECT * FROM `cart` WHERE `customer_email` = '$customeremail'";

$result = mysqli_query($conn, $selectQuery) or die("Database error " . mysqli_error($conn));

while ($row = mysqli_fetch_array($result)) {
	if(!isset($_POST['norek'])){
		$product_ID = $row['product_id'];
		$quantity = $row['quantity'];
		$address = $_POST['address'];

		$query = "INSERT INTO `orders`( `product_id`, `quantity`, `address`, `customer_email`, `date_added`) VALUES ('$product_ID', '$quantity', '$address', '$customeremail', NOW())";
		mysqli_query($conn, $query) or die("Error" . mysqli_error($conn));
	} else {
		$product_ID = $row['product_id'];
		$quantity = $row['quantity'];
		$address = $_POST['address'];
		$bank = $_POST['norek'];

		$query = "INSERT INTO `orders`( `product_id`, `quantity`, `address`, `bank`, `customer_email`, `date_added`) VALUES ('$product_ID', '$quantity', '$address', '$bank', '$customeremail', NOW())";
		mysqli_query($conn, $query) or die("Error" . mysqli_error($conn));
	}
}

if (!mysqli_errno($conn)) {
	//order has been placed successfully.
	//NOW CLEAR THE CART FOR CURRENT USER
	$deletequery = "DELETE FROM `cart` WHERE `customer_email` = '$customeremail'";
	mysqli_query($conn, $deletequery) or die("error two: " . mysqli_error($conn));
	//THEN UNSET TOTALCOST
	unset($_SESSION['totalCost']);
	echo "<script>alert('Order has been placed!')</script>";
	echo "<script>window.location.replace('dashboard.php')</script>";
}
