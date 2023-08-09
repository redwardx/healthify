<?php
session_start();
if(!isset($_SESSION['email'])){
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}
include("connections/localhost.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['totalCost']) || (int)$_SESSION['totalCost'] <= 0) {
    //KICK USER OUT OF THIS PAGE
    header('product.php');
}
global $name;
$name = $_SESSION['name'];


global $totalCost;
$totalCost = '';
$totalCost = $_SESSION['totalCost'];

?>

<?php include("includes/header.php"); ?>


<?php include("includes/navbar.php"); ?>
<?php
	$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] );
	$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	$qty =  mysqli_query($conn, "SELECT sum(quantity) as total FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC") or die(mysqli_error($conn));
	$data=mysqli_fetch_assoc($qty);
	
	if ($data['total'] == 0) exit('<p align="center"> Your Cart is Empty</p>'); 
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
					    while ($row = mysqli_fetch_array($result)) {
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
<script>
    let textboxes = document.querySelectorAll('input[name="norek"]');
    let label = document.querySelectorAll('label[name="norek"]');

    document.querySelectorAll('input[name=target]')
    .forEach(function(radio) {
        radio.addEventListener('change', function(e) {
        let value = e.target.value;

        if (value === 'tf') {
            textboxes.forEach(function(textbox) {
                textbox.hidden = false;
                textbox.disabled = false;
                textbox.required = true;
            });
        } else if (value === 'cod') {
            textboxes.forEach(function(textbox) {
                textbox.hidden = true;
                textbox.disabled = true;
                textbox.required = false;
            });
        }
        });
    });
</script>
<?php include("includes/footer.php"); ?>