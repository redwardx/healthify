<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database

$id=$_GET['product'];

$query = "Delete From products Where productID='$id'";
$hasil = mysqli_query($conn,$query);
    if($hasil){
        header("location:products.php");
    }
    else{
        echo '<script language="javascript">alert("Hapus data gagal"); document.location="products.php";</script>';
    }
?>