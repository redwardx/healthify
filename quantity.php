<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}								//jika belum, redirect
if(!isset($_SESSION['user'])){  //cek sesi apakah bukan user
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}								//jika bukan, redirect
include("Connections/localhost.php");
global $conn;
	//jika tombol ubah ditekan
		if(isset($_POST['submit'])){ 
			//memeriksa jika quantity yang baru adalah 0
			if($_POST['quantity']==0) { 
				$cart_id = htmlspecialchars(stripslashes(trim($_GET['id'])));
				$cart_id = mysqli_real_escape_string($conn, $cart_id);
				//menghapus produk tersebut dari cart
				$query = "DELETE FROM `cart` WHERE `cart_id`='$cart_id'";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if ($result === TRUE) {
					echo "<script>window.location.replace('cart.php')</script>";
				} 
			}else{ //jika quantity yg baru bukan 0
				$cart_id = htmlspecialchars(stripslashes(trim($_GET['id'])));
				$cart_id = mysqli_real_escape_string($conn, $cart_id);
                $val = $_POST['quantity'];
				//mengupdate quantity produk tersebut pada cart
				$query = "UPDATE `cart` SET `quantity` = '$val' WHERE `cart_id`='$cart_id'";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if ($result === TRUE) {
					echo "<script>window.location.replace('cart.php')</script>";
				} 
			} 
		} 
?>