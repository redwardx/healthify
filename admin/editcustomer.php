<?php
session_start();
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="../index.php";</script>';
} //jika belum login, redirect ke halaman login
if(!isset($_SESSION['admin'])){ //cek apakah sesi bukan admin
	echo '<script language="javascript">alert("Anda bukan Admin!"); document.location="../dashboard.php";</script>';
} //jika bukan admin, redirect ke dashboard user
include('../connections/localhost.php'); //panggil database

$id = $_GET['customer'];
 
$result = mysqli_query($conn, "SELECT * FROM user WHERE userid=$id");
 
while($data = mysqli_fetch_array($result))
{
    $id = $data['userid'];
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
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
                    Form Edit Kategori
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input name="name" type="text" class="form-control" id="floatingInput" placeholder="Nama" required value=<?php echo $name;?>>
                            <label for="floatingInput">Nama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="Email" required value=<?php echo $email;?>>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="phone" type="text" class="form-control" id="floatingInput" placeholder="Phone" required value=<?php echo $phone;?>>
                            <label for="floatingInput">No. HP</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingInput" placeholder="Password">
                            <label for="floatingInput">Password</label>
                        </div>
                        <input class="btn btn-primary" type="submit" name="update" value="Simpan">
                    </form>
                </div>
            </div>
    <?php

    global $conn;
    if (isset($_POST['update'])) {

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $phone = mysqli_real_escape_string($conn, $_POST['phone']);

      //----------------------------- Jika kolom password diisi ------------------------//
      if($_POST['password']){
        $password = mysqli_real_escape_string($conn, $_POST['password']); //mengambil nilai dari input password 
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);     //untuk mengenkripsi nilai dari input password
        $query="update user set name='$name', email ='$email', phone='$phone', password= '$hashedpassword' where userid='$id'"; //query berjalan dengan mengubah password
        $hasil = mysqli_query($conn, $query);
      //----------------------------- Jika kolom password kosong ------------------------//  
      } else {
        $query="update user set name='$name', email ='$email', phone='$phone' where userid='$id'"; //query berjalan tanpa mengubah password
        $hasil = mysqli_query($conn, $query);
      }
      if($hasil){
        header("location:customer.php");
      }else{
        echo '<script language="javascript">alert("Update gagal"); document.location="customer.php";</script>';
      } 
    }
    ?>
        </div>
    </main>
<?php include("template/footer.php");?> 