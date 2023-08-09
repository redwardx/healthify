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
          <h1 class="mt-4">Produk</h1>
          <?php
            $query = "SELECT * FROM `products`";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          ?>
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-end">
              <a href="addproduct.php" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add</a>
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga (Rp.)</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td><?= $row['productID'] ?></td>
                    <td><?= $row['productname'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td style="text-align: center;">
                      <a href="editproduct.php?product=<?= $row['productID'] ?>"class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                      <a href="deleteproduct.php?product=<?= $row['productID'] ?>"onClick="return confirmDelete()" class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
                </table>
              </div>
            </div>
        </div>
    </main>
<?php include("template/footer.php");?> 
  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete?");
    }
  </script>
  <!-- END OF LIST OF PRODUCTS -->

</body>

</html>