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

$customeremail = mysqli_real_escape_string($conn, $_SESSION['email']);
$totalCost = mysqli_real_escape_string($conn, $_SESSION['totalCost']);

//mengambil semua data dari cart 
$selectQuery = "SELECT * FROM `cart` WHERE `customer_email` = '$customeremail'";

$result = mysqli_query($conn, $selectQuery) or die("Database error " . mysqli_error($conn));

//jika data dari cart sudah diambil
while ($row = mysqli_fetch_array($result)) {
	//memeriksa apakah user menggunakan cod atau bank
	if(!isset($_POST['norek'])){
		//jika menggunakan cod, maka akan mengambil 3 input
		$product_ID = $row['product_id'];
		$quantity = $row['quantity'];
		$address = $_POST['address'];

		//melakukan operasi insert data ke orders, karena bank tidak diisi, maka pada database akan bernilai default 0
		$query = "INSERT INTO `orders`( `product_id`, `quantity`, `address`, `customer_email`, `date_added`) VALUES ('$product_ID', '$quantity', '$address', '$customeremail', NOW())";
		mysqli_query($conn, $query) or die("Error" . mysqli_error($conn));
	} else {
		//jika menggunakan bank, maka akan mengambil 4 input
		$product_ID = $row['product_id'];
		$quantity = $row['quantity'];
		$address = $_POST['address'];
		$bank = $_POST['norek'];

		//melakukan operasi insert data ke orders
		$query = "INSERT INTO `orders`( `product_id`, `quantity`, `address`, `bank`, `customer_email`, `date_added`) VALUES ('$product_ID', '$quantity', '$address', '$bank', '$customeremail', NOW())";
		mysqli_query($conn, $query) or die("Error" . mysqli_error($conn));
	}
}

//jika operasi insert data ke orders berhasil
if (!mysqli_errno($conn)) {
	//membersihkan cart untuk customer tersebut menggunakan query dibawah
	$deletequery = "DELETE FROM `cart` WHERE `customer_email` = '$customeremail'";
	mysqli_query($conn, $deletequery) or die("error two: " . mysqli_error($conn));
	//setelah itu, hapus sesi untuk totalcost dan redirect ke dashboard
	unset($_SESSION['totalCost']);
	echo "<script>alert('Pesanan anda sudah diproses')</script>";
	echo "<script>window.location.replace('dashboard.php')</script>";
}
