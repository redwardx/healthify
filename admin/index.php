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
                        <h1 class="mt-4 text-light">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="container-fluid px-4">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-dark border-primary text-primary mb-4">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-8"><i class="fas fa-users fa-3x"></i><h5 class="card-title mt-3">Customer</h5></div>
                                                <?php
                                                    $query = "SELECT COUNT(*) AS count FROM `user` WHERE `level`= '0'";        //menghitung jumlah user dengan level 0
                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    $custCount = (int) mysqli_fetch_assoc($result)["count"];                //mengambil data jumlah customer
                                                ?>
                                                <div class="col-3"><h1><?= $custCount ?></h1></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-dark border-warning text-warning mb-4">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-8"><i class="fas fa-th-list fa-3x"></i><h5 class="card-title mt-3">Kategori</h5></div>
                                                <?php
                                                    $query = "SELECT COUNT(*) AS count FROM `categories`";        //menghitung jumlah user dengan level 0
                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    $categoriesCount = (int) mysqli_fetch_assoc($result)["count"];                //mengambil data jumlah customer
                                                ?>
                                                <div class="col-3"><h1><?= $categoriesCount ?></h1></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-dark border-success text-success mb-4">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-8"><i class="fas fa-archive fa-3x"></i><h5 class="card-title mt-3">Produk</h5></div>
                                                <?php
                                                    $query = "SELECT COUNT(*) AS count FROM `products`";        //menghitung jumlah user dengan level 0
                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    $prodCount = (int) mysqli_fetch_assoc($result)["count"];                //mengambil data jumlah customer
                                                ?>
                                                <div class="col-3"><h1><?= $prodCount ?></h1></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-dark border-danger text-danger mb-4">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-8"><i class="fas fa-shopping-cart fa-3x"></i><h5 class="card-title mt-3">Pesanan</h5></div>
                                                <?php
                                                    $query = "SELECT COUNT(*) AS count FROM `orders`";        //menghitung jumlah user dengan level 0
                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    $ordCount = (int) mysqli_fetch_assoc($result)["count"];                //mengambil data jumlah customer
                                                ?>
                                                <div class="col-3"><h1><?= $ordCount ?></h1></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
<?php include("template/footer.php");?> 