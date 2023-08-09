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
                    Form Tambah Produk
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control" id="floatingInput" placeholder="Nama Produk" maxlength="30" required>
                            <label for="floatingInput">Nama Produk</label>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp.</span>
                            <div class="form-floating">
                            <input name="price" type="text" class="form-control" placeholder="Harga" required>
                                <label for="price" class="form-label">Harga</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="category" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option disabled selected>Pilih Kategori</option>
                                <?php 
                                  global $conn;
                                  $sql=mysqli_query($conn,"SELECT * FROM categories"); //query untuk memanggil categories
                                  while ($data=mysqli_fetch_array($sql)) {             //jika berhasil, maka variabel data akan berisi array dari query 
                                ?>
                                  <option value="<?=$data['category_name']?>"><?=$data['category_name']?></option> <!-- Memanggil array dari kategori dengan bentuk option -->
                                <?php
                                  }
                                ?>
                            </select>
                            <label for="floatingSelect">Kategori</label>
                        </div>
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Gambar Produk</label>
                            <div class="input-group">
                                <input name="product_image" type="file" accept=".jpg, .jpeg, .png" required class="form-control" id="inputGroupFile01">
                            </div>
                        </div>
                        
                        <input class="btn btn-primary" type="submit" name="insert" value="Simpan">
                        
                    </form>
                </div>
            </div>

  <!-- START UPLOAD FILE CODE BELOW -->
    <?php

    global $conn;
    if (isset($_POST['insert'])) {

      $productname = mysqli_real_escape_string($conn, $_POST['name']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);

      //-----------------------------proses upload gambar -----------//
      $nama_img = $_FILES['product_image']['name'];     //nama gambar yang diupload
      $sumber = $_FILES['product_image']['tmp_name'];   //ketika gambar diupload, gambar akan tersimpan di temporary

      $target = "../uploads/";                          //tempat kita menyimpan gambar

      $pindah = move_uploaded_file($sumber, $target.$nama_img); //memindahkan gambar dari temporary ke penyimpanan utama, yaitu target
      if($pindah){                                              
        $query = "insert into products values('','$productname','$price','$category','$nama_img')";
        $hasil = mysqli_query($conn, $query);                   //jika berhasil memindahkan gambar, maka simpan nama dari gambar ke dalam database
        if($hasil){
          echo '<script language="javascript">alert("Tambah berhasil"); document.location="products.php";</script>';  //jika semua operasi berhasil, redirect tanpa alert
        }else{
          echo '<script language="javascript">alert("Penyimpanan gagal"); document.location="products.php";</script>'; //jika gagal, redirect dengan alert
        } 
      } else {
        echo '<script language="javascript">alert("Penyimpanan gagal"); document.location="products.php";</script>';
      }
    }
    ?>
  <!-- selesai -->
        </div>
    </main>
<?php include("template/footer.php");?> 