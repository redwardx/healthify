<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database

$id=$_GET['customer'];

$query = "Delete From user Where userid='$id'";
$hasil = mysqli_query($conn,$query);
    if($hasil){
        echo '<script language="javascript">alert("Hapus berhasil"); document.location="customer.php";</script>';
    }
    else{
        echo '<script language="javascript">alert("Hapus data gagal"); document.location="customer.php";</script>';
    }
?>