<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){ //cek sesi apakah sudah login
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}								//jika belum, redirect
if(!isset($_SESSION['user'])){  //cek sesi apakah bukan user
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}								//jika bukan, redirect

include("connections/localhost.php");

global $name;
$name = $_SESSION['name']; //mengambil data nama dari sesi

global $totalCost;
$totalCost = $_SESSION['totalCost']; //mengambil data totalcost dari sesi
?>

<!-- memanggil template dari folder include-->
<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>
<!-------------------------------------------->

<?php
	$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] ); //mendefinisikan variabel baru dengan mengambil data email dari session
	$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC"; //mendapatkan data dari tabel cart yang dimiliki oleh user dengan email yang sama dengan customer email
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	$qty =  mysqli_query($conn, "SELECT sum(quantity) as total FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC") or die(mysqli_error($conn));
	//menjumlahkan total record dari quantity
	$data=mysqli_fetch_assoc($qty);

?>
    <div class="container mt-5">
        <h1 class="py-3">Invoice</h1>
        <form action="placeOrder.php" method="post">
            <div class="card">
                <div class="card-header">
                    Informasi tagihan
                </div>
                <div class="card-body">
                    <!--Input dibawah bersifat hidden untuk melakukan proses konfirmasi pesanan, karena menggunakan value dari page sebelumnya-->
                        <input type="text" class="form-control" maxlength="20" id="name" value="<?php echo $name ?>" hidden>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $_POST['address'] ?>" hidden>
                        <?php
                            if (isset($_POST['norek'])) {           //jika sebelumnya user memilih transfer bank dan input "norek" terisi
                                $bank = $_POST['norek'];            
                                echo "<input type='text' class='form-control' name='norek' id='norek' value='$bank' hidden>";
                                //maka akan terdapat input "norek" dengan value dari page sebelumnya
                            } else {                                //jika sebelumnya input "norek" tidak terisi
                                echo "<input type='text' class='form-control' name='norek' id='norek' hidden disabled>";
                            }       //maka input norek akan disabled
                        ?>
                    <!------------------------------------------------------------------------------------------------------------------------->
                    <h5 class="card-title">Detail</h5>
                    <p class="card-text">Nama Customer : <?php echo $name ?></p>
                    <p class="card-text">Alamat Pengiriman : <?php echo $_POST['address'] ?></p>
                    <?php
                        if (isset($_POST['norek'])) {       //jika sebelumnya user memilih transfer bank dan input "norek" terisi
                            $bank = $_POST['norek'];
                            echo "<p class='card-text'>Metode Pembayaran : Bank Transfer ($bank)</p>";
                        } else {                            //jika sebelumnya user memilih cod dan input "norek" tidak terisi
                            echo "<p class='card-text'>Metode Pembayaran : Cash On Delivery</p>";
                        }
                    ?>   
                    <table>
                            <tr>
                                <th>Nama Barang&nbsp;</th>
                                <th>Qty. &nbsp;</th>
                                <th>Harga</th>
                            </tr>
                    <?php
					    while ($row = mysqli_fetch_array($result)) { //mengambil data cart dan dijadikan array dalam variabel row
					?>
                            <tr>
                                <td><?php echo $row['productname'] ?></td>  
                                <td><?php echo $row['quantity'] ?></td>
                                <td>Rp. <?php echo $row['quantity']*$row['price'] ?></td>
                            </tr>
                    <?php
                        }
                    ?>
                             <tr>
                                <td colspan="2" class="fw-bold">Total</td>
                                <td class="fw-bold">Rp. <?php echo $totalCost ?></td>
                            </tr>
                        </table>
                        <button name="pay" type="submit" class="btn btn-secondary mt-3">Konfirmasi</button>
                        </form>

                        <!-------------------------PRINT INVOICE-------------------------------------------------->
                        <form action="invoice.php" method="post"> <!--mengirim data checkout ke halaman invoice-->
                            <!--Untuk membuat sebuah invoice, dibutuhkan data checkout yang sudah diisi sebelumnya-->
                            <input type="text" class="form-control" maxlength="20" id="name" value="<?php echo $name ?>" hidden>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $_POST['address'] ?>" hidden>
                            <?php
                                if (isset($_POST['norek'])) {           //jika sebelumnya user memilih transfer bank dan input "norek" terisi
                                    $bank = $_POST['norek'];            
                                    echo "<input type='text' class='form-control' name='norek' id='norek' value='$bank' hidden>";
                                    //maka akan terdapat input "norek" dengan value dari page sebelumnya
                                } else {                                //jika sebelumnya input "norek" tidak terisi
                                    echo "<input type='text' class='form-control' name='norek' id='norek' hidden disabled>";
                                }       //maka input norek akan disabled
                            ?>
                        <button name="print" type="submit" class="btn btn-primary mt-3">Cetak</button>
                        </form>
                        <!-------------------------------------------------------------------------------->
                </div>
            </div>
    </div>
<?php include("includes/footer.php"); ?>