<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}								//jika belum, redirect
if(!isset($_SESSION['user'])){  //cek sesi apakah bukan user
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}								//jika bukan, redirect
include('connections/localhost.php');

$id = $_GET['id'];
 
$result = mysqli_query($conn, "SELECT * FROM products WHERE productID=$id");
 
while($data = mysqli_fetch_array($result))
{
    $id = $data['productID'];
    $name = $data['productname'];
    $desc = $data['description'];
    $price = $data['price'];
    $image = $data['product_image'];
}

?>

<!-- memanggil template dari folder include-->
<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>
<!-------------------------------------------->

<div class="container py-5">
    <div class="row mb-3">
		<div class="col-7 mt-5">
	        <div class="card" style="width: 45rem;">
				<img src="<?php echo basename('uploads/') . "/" .  $image; ?>" class="card-img-top" width="500" height="500">
				<div class="card-body">
                    <h5 class="card-title">Deskripsi</h5>
                    <p class="card-title"><?php echo $desc;?></p>
				</div>
		    </div>
        </div>
        <div class="col-5 mt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $name;?></h5>
					<p class="card-text"><?php echo "Rp.". $price; ?></p>
                    <form method="post" action="addtocart.php?id=<?php echo $id; ?>">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Qty.</span>
                            <input type="number" name="quantity" value="1" class="form-control" placeholder="Quantity" aria-describedby="button-addon2">
                        </div>
                        <button class="btn btn-secondary" type="submit" name="submit">Tambah ke Keranjang</button>
                    </form>
				</div>
		    </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>