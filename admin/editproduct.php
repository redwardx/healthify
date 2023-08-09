<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database

$id = $_GET['product'];
 
$result = mysqli_query($conn, "SELECT * FROM products WHERE productID=$id");
 
while($data = mysqli_fetch_array($result))
{
    $id = $data['productID'];
    $name = $data['productname'];
    $price = $data['price'];
    $category = $data['category'];
}
?>
<?php include("template/header.php");?>
<?php include("template/navbar.php");?> 
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
          <div class="card mb-4 mt-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Form Edit Produk
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control" id="floatingInput" placeholder="Nama Produk" maxlength="30" required value="<?php echo $name;?>">
                            <label for="floatingInput">Nama Produk</label>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp.</span>
                            <div class="form-floating">
                            <input name="price" type="text" class="form-control" placeholder="Harga" required value=<?php echo $price;?>>
                                <label for="price" class="form-label">Harga</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="category" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option disabled selected>Pilih Kategori</option>
                                <?php 
                                  global $conn;
                                  $sql=mysqli_query($conn,"SELECT * FROM categories");
                                  while ($data=mysqli_fetch_array($sql)) {
                                ?>
                                  <option value="<?=$data['category_name']?>"><?=$data['category_name']?></option> 
                                <?php
                                  }
                                ?>
                            </select>
                            <label for="floatingSelect">Kategori</label>
                        </div>
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Gambar Produk</label>
                            <div class="input-group">
                                <input name="product_image" type="file" accept=".jpg, .jpeg, .png" class="form-control" id="inputGroupFile01">
                            </div>
                        </div>
                        
                        <input class="btn btn-primary" type="submit" name="update" value="Simpan">
                        
                    </form>
                </div>
            </div>

  <!-- START UPLOAD FILE CODE BELOW -->
    <?php

    global $conn;
    if (isset($_POST['update'])) {

      $productname = mysqli_real_escape_string($conn, $_POST['name']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);

      //-----------------------------proses penyimpanan gambar-----------//
      $nama_img = $_FILES['product_image']['name'];
      $sumber = $_FILES['product_image']['tmp_name'];

      $target = "../uploads/";

      $pindah = move_uploaded_file($sumber, $target.$nama_img);
      if($sumber != ""){              //jika input gambar tidak kosong
        $pindah;                      
        $query="update products set productname='$name', price ='$price', category='$category', product_image= '$nama_img' where productID='$id'"; //update beserta nama gambar pada database
        $hasil = mysqli_query($conn, $query);
      } else {                        //jika input gambar kosong
        $query="update products set productname= '$name', price = '$price', category='$category' where productID='$id'"; //update tanpa menyertakan kolom nama gambar
        $hasil = mysqli_query($conn, $query);
      }
      if($hasil){
        echo '<script language="javascript">alert("Ubah berhasil"); document.location="products.php";</script>';
      }else{
        echo '<script language="javascript">alert("Update gagal"); document.location="products.php";</script>';
      } 
    }
    ?>
  <!-- END UPLOAD FILE ABOVE-->
        </div>
    </main>
<?php include("template/footer.php");?> 