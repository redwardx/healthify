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
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Kategori</h1>
          <?php
            $query = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn)); //memanggil data dari tabel kategori
          ?>
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-end">
              <a href="addcategories.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while ($row = mysqli_fetch_array($result)) { //mengambil data dari tabel kategori dan dijadikan array
                  ?>
                  <tr>
                    <td><?= $row['category_id'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td style="text-align: center;">
                      <a href="editcategories.php?categories=<?= $row['category_id'] ?>"><button class="btn btn-secondary">Edit</button></a>
                      <a href="deletecategories.php?categories=<?= $row['category_id'] ?>"><button onClick="return confirmDelete()" class="btn btn-danger">Delete</button></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
                </table>
              </div>
            </div>
        </div>
    </main>
  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete?");
    }
  </script>
<?php include("template/footer.php");?> 
