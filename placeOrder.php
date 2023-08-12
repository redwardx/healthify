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

if(!isset($_POST['norek'])){
	$address = $_POST['address'];

    // Insert data ke tabel orders
    $query = "INSERT INTO `orders`(`total_bayar`, `address`, `customer_email`, `date_added`) VALUES ('$totalCost', '$address', '$customeremail', NOW())";

    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn); // Ambil order_id dari data yang baru disimpan
        
        // Ambil data dari cart
        $selectQuery = "SELECT * FROM `cart` WHERE `customer_email` = '$customeremail'";
        $result = mysqli_query($conn, $selectQuery) or die("Database error " . mysqli_error($conn));

        // Loop untuk menyimpan detail pesanan
        while ($row = mysqli_fetch_array($result)) {
            $product_ID = $row['product_id'];
            $quantity = $row['quantity'];
            
            $querydetail = "INSERT INTO detail_orders (`product_id`, `quantity`, `order_id`) VALUES ('$product_ID', '$quantity', $order_id)";
            mysqli_query($conn, $querydetail);
        }
        
        // Hapus data dari cart
        $deletequery = "DELETE FROM `cart` WHERE `customer_email` = '$customeremail'";
        mysqli_query($conn, $deletequery) or die("error two: " . mysqli_error($conn));
        
        // Setelah operasi selesai, redirect ke dashboard
        unset($_SESSION['totalCost']);
        echo "<script>alert('Pesanan anda sudah diproses')</script>";
        echo "<script>window.location.replace('dashboard.php')</script>";
    }
} else {
	$address = $_POST['address'];
    $bank = $_POST['norek'];

    // Insert data ke tabel orders
    $query = "INSERT INTO `orders`(`total_bayar`, `address`, `bank`, `customer_email`, `date_added`) VALUES ('$totalCost', '$address', '$bank', '$customeremail', NOW())";

    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn); // Ambil order_id dari data yang baru disimpan
        
        // Ambil data dari cart
        $selectQuery = "SELECT * FROM `cart` WHERE `customer_email` = '$customeremail'";
        $result = mysqli_query($conn, $selectQuery) or die("Database error " . mysqli_error($conn));

        // Loop untuk menyimpan detail pesanan
        while ($row = mysqli_fetch_array($result)) {
            $product_ID = $row['product_id'];
            $quantity = $row['quantity'];
            
            $querydetail = "INSERT INTO detail_orders (`product_id`, `quantity`, `order_id`) VALUES ('$product_ID', '$quantity', $order_id)";
            mysqli_query($conn, $querydetail);
        }
        
        // Hapus data dari cart
        $deletequery = "DELETE FROM `cart` WHERE `customer_email` = '$customeremail'";
        mysqli_query($conn, $deletequery) or die("error two: " . mysqli_error($conn));
        
        // Setelah operasi selesai, redirect ke dashboard
        unset($_SESSION['totalCost']);
        echo "<script>alert('Pesanan anda sudah diproses')</script>";
        echo "<script>window.location.replace('dashboard.php')</script>";
    }
}
