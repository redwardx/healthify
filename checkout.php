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
        <h1 class="py-3">Checkout</h1>
        <form action="confirmorder.php" method="post">
            <div class="card">
                <div class="card-header">
                    Data Pesanan
                </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" maxlength="20" id="name" value="<?php echo $name ?>" disabled>
                        <label for="name">Nama Customer</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="address" placeholder="Leave a comment here" id="address" required></textarea>
                        <label for="address">Alamat Pengiriman</label>
                    </div>
                    <p> Pilih Metode Pembayaran </p>
                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="radio" name='target' value='cod' required>
                        <label class="form-check-label" for="inlineRadio1">COD</label>
                    </div>
                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type='radio' name='target' value='tf'>
                        <label class="form-check-label" for="inlineRadio2">Transfer Bank</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="norek" id="norek" class="form-control" placeholder="No. Rekening" hidden>
                    </div>
                    <h5 class="card-title">Detail</h5>
                    <table>
                            <tr>
                                <th>Nama Barang&nbsp;</th>
                                <th>Qty. &nbsp;</th>
                                <th>Harga</th>
                            </tr>
                    <?php
					    while ($row = mysqli_fetch_array($result)) { //mengambil data dari query result dan dijadikan array pada variabel row
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
                        <button name="pay" type="submit" class="btn btn-secondary mt-3">Lanjutkan</button>
                </div>
            </div>
        </form>
    </div>
<!-----------Pengaturan untuk radio button------------>
<script> 
    let textboxes = document.querySelectorAll('input[name="norek"]'); //mendefinisikan input dengan nama "norek" kedalam variabel javascript

    document.querySelectorAll('input[name=target]').forEach(function(radio) { //mendefinisikan input radio dengan nama "target" kedalam variabel javascript
        radio.addEventListener('change', function(e) {           //jika radio button berganti
            let value = e.target.value;

            if (value === 'tf') {                               //jika value radio bernilai "tf"
                textboxes.forEach(function(textbox) {           //akan mempengaruhi input norek
                    textbox.hidden = false;                     //input norek muncul
                    textbox.disabled = false;                   //input norek dapat diisi
                    textbox.required = true;                    //input norek harus diisi
                });
            } else if (value === 'cod') {                       //jika value radio bernilai "cod"
                textboxes.forEach(function(textbox) {           //akan mempengaruhi input norek
                    textbox.hidden = true;                      //input norek akan hilang
                    textbox.disabled = true;                    //input norek tidak dapat diisi
                    textbox.required = false;                   //input norek tidak wajib diisi
                });
            }
        });
    });
</script>
<!--------------------------------------------------->
<?php include("includes/footer.php"); ?>