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
global $conn;

	$product_id = htmlspecialchars(stripslashes(trim($_GET['id']))); 
	$product_id = mysqli_real_escape_string($conn, $product_id);
	$customeremail = mysqli_real_escape_string($conn, $_SESSION['email']);

	//untuk memeriksa, apakah produk tersebut sudah masuk cart
	$checkQuery = "SELECT `customer_email`, `product_id` FROM `cart` WHERE `customer_email` = '$customeremail' AND `product_id` = '$product_id'";

	$result = mysqli_query($conn, $checkQuery) or die("Database error " . mysqli_error($conn));
	
	$count = mysqli_num_rows($result);

	//jika produk sudah masuk cart
	if ($count > 0) {
		//tambahkan 1 quantity pada produk tersebut
		$query = "UPDATE `cart` SET `quantity` = `quantity` + 1 WHERE `customer_email` = '$customeremail' AND `product_id`='$product_id'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		echo "<script>alert('Berhasil ditambahkan ke keranjang')</script>";
		echo "<script>window.history.back();</script>";
	} else {
		//jika belum, maka tambah data baru ke tabel cart
		$query = "INSERT INTO `cart`( `customer_email`, `product_id`,  `quantity`, `date_added`) VALUES ('$customeremail','$product_id', 1 ,NOW())";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
		echo "<script>alert('Berhasil ditambahkan ke keranjang')</script>";
		echo "<script>window.history.back();</script>";
}
