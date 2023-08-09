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
          <h1 class="mt-4">Customer</h1>
          <?php
            $query = "SELECT * FROM `user` where level = '0'";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          ?>
          <div class="card mb-4">
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No. HP</th>
                    <th scope="col">Tanggal Bergabung</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td><?= $row['userid'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['datejoined'] ?></td>
                    <td style="text-align: center;">
                      <a href="editcustomer.php?customer=<?= $row['userid'] ?>"><button class="btn btn-secondary">Edit</button></a>
                      <a href="deletecustomer.php?customer=<?= $row['userid'] ?>"><button onClick="return confirmDelete()" class="btn btn-danger">Delete</button></a>
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