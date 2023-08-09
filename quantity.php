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
		if(isset($_POST['submit'])){ 
			if($_POST['quantity']==0) { 
				$cart_id = htmlspecialchars(stripslashes(trim($_GET['id'])));
				$cart_id = mysqli_real_escape_string($conn, $cart_id);
				$customeremail = mysqli_real_escape_string($conn, $_SESSION['email']);
				$query = "DELETE FROM `cart` WHERE `cart_id`='$cart_id'";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if ($result === TRUE) {
					echo "<script>window.location.replace('cart.php')</script>";
				} 
			}else{ 
				$cart_id = htmlspecialchars(stripslashes(trim($_GET['id'])));
				$cart_id = mysqli_real_escape_string($conn, $cart_id);
                $val = $_POST['quantity'];
				$customeremail = mysqli_real_escape_string($conn, $_SESSION['email']);
				$query = "UPDATE `cart` SET `quantity` = '$val' WHERE `cart_id`='$cart_id'";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if ($result === TRUE) {
					echo "<script>window.location.replace('cart.php')</script>";
				} 
			} 
		} 
?>