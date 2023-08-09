<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database
?>
<?php include("template/header.php");?>
<?php include("template/navbar.php");?> 
            <div id="layoutSidenav_content" class="bg-dark">
                <main>
                    <div class="container-fluid px-4">
                        
                    </div>
                </main>
<?php include("template/footer.php");?> 