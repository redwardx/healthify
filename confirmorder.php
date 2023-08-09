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
        <h1 class="py-3">Invoice</h1>
        <form action="placeOrder.php" method="post">
            <div class="card">
                <div class="card-header">
                    Informasi tagihan
                </div>
                <div class="card-body">
                        <input type="text" class="form-control" maxlength="20" id="name" value="<?php echo $name ?>" hidden>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $_POST['address'] ?>" hidden>
                        <?php
                            if (isset($_POST['norek'])) {
                                $bank = $_POST['norek'];
                                echo "<input type='text' class='form-control' name='norek' id='norek' value='$bank' hidden>";
                            } else {
                                echo "<input type='text' class='form-control' name='norek' id='norek' hidden>";
                            }
                        ?>
                    <h5 class="card-title">Detail</h5>
                    <p class="card-text">Nama Customer : <?php echo $name ?></p>
                    <p class="card-text">Alamat Pengiriman : <?php echo $_POST['address'] ?></p>
                    <?php
                        if (isset($_POST['norek'])) {
                            $bank = $_POST['norek'];
                            echo "<p class='card-text'>Metode Pembayaran : Bank Transfer ($bank)</p>";
                        } else {
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
                        <button name="pay" type="submit" class="btn btn-secondary mt-3">Konfirmasi</button>
                        </form>
                        <form action="invoice.php" method="post">
                            <input type="text" class="form-control" maxlength="20" id="name" value="<?php echo $name ?>" hidden>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $_POST['address'] ?>" hidden>
                            <?php
                                if (isset($_POST['norek'])) {
                                    $bank = $_POST['norek'];
                                    echo "<input type='text' class='form-control' name='norek' id='norek' value='$bank' hidden>";
                                } else {
                                    echo "<input type='text' class='form-control' name='norek' id='norek' hidden>";
                                }
                            ?>
                        <button name="print" type="submit" class="btn btn-primary mt-3">Cetak</button>
                        </form>
                </div>
            </div>
    </div>
<?php include("includes/footer.php"); ?>