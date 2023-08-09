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
<?php include("template/header.php"); //panggil template header?>
<?php include("template/navbar.php"); //panggil template navbar?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
          <div class="card mb-4 mt-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Form Tambah Kategori
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control" id="floatingInput" placeholder="Nama Produk" maxlength="30" required>
                            <label for="floatingInput">Nama Kategori</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="desc" class="form-control" placeholder="Deskripsi" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Deskripsi</label>
                        </div>
                        <input class="btn btn-primary" type="submit" name="insert" value="Simpan">
                        
                    </form>
                </div>
            </div>

  <!-- Mulai proses tambah data ke database -->
    <?php

    global $conn;                   //digunakan untuk memanggil variabel publik yang bernama conn
    if (isset($_POST['insert'])) {  //jika submit ditekan

      $name = mysqli_real_escape_string($conn, $_POST['name']); //membuat variabel name dengan mengambil nilai dari input pada form input yang memiliki nama "name"
      $desc = mysqli_real_escape_string($conn, $_POST['desc']); //membuat variabel desc dengan mengambil nilai dari input pada form input yang memiliki nama "desc"
      $query = "insert into categories values('','$name','$desc')"; //menetapkan query untuk operasi ke database
      $hasil = mysqli_query($conn, $query); //mengeksekusi query dengan memanggil koneksi database dan variabel query yang telah ditetapkan
      if($hasil){
        header("location:categories.php"); //jika berhasil, maka redirect
      }else{
        echo '<script language="javascript">alert("Penyimpanan gagal"); document.location="categories.php";</script>'; //jika gagal, maka akan muncul alert dan redirect
      }       
    }
    ?>
  <!-- selesai -->
        </div>
    </main>
<?php include("template/footer.php"); //memanggil template footer ?> 