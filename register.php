<?php
session_start();
include('connections/localhost.php');

?>

<!-- memanggil template dari folder include-->
<?php include("includes/header.php"); ?>
<!-------------------------------------------->
	<body class="bg-warning">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
										<form action="register.php" method="post" enctype="multipart/form-data">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="name" type="text" placeholder="John Doe" />
                                                <label>Nama</label>
                                            </div>
											<div class="form-floating mb-3">
                                                <input class="form-control" name="username" type="text" placeholder="johndoe" />
                                                <label>Username</label>
                                            </div>
											<div class="form-floating mb-3">
                                                <input class="form-control" name="birth" type="date" placeholder="00-00-0000" />
                                                <label>Tanggal Lahir</label>
                                            </div>
											<div class="form-floating mb-3">
                                                <input class="form-control" name="phone" type="text" placeholder="08XXXXXXXX" />
                                                <label>No. Telp</label>
                                            </div>
											<div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email" placeholder="example@example.com" />
                                                <label>Email</label>
                                            </div>
											<div class="form-floating mb-3">
												<textarea name="address" class="form-control" placeholder="Alamat" id="floatingTextarea2" style="height: 100px"></textarea>
												<label for="floatingTextarea2">Alamat</label>
											</div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="password" type="password" placeholder="Create a password" />
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="confirmPass" type="password" placeholder="Confirm password" />
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
												<div class="d-grid"><input class="btn btn-dark btn-block" name="register" type="submit" value="Buat Akun"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Sudah punya akun? <a href="index.php">Login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
		<?php
		// proses register

		/** sanitize input */
		function cleanInput(string $data)
		{
			//this to clean and sanitize our input data
			$data = strip_tags(trim($data));
			$data = htmlspecialchars($data);
			$data = stripslashes($data);
			return ($data);
		}

		if (isset($_POST['register'])) {
			global $conn;
			//mengambil semua input pada form register
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$birth = mysqli_real_escape_string($conn, $_POST['birth']);
			$phone =  mysqli_real_escape_string($conn, $_POST['phone']);
			$email =  mysqli_real_escape_string($conn, $_POST['email']);
			$address = mysqli_real_escape_string($conn, $_POST['address']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$confirmPass = mysqli_real_escape_string($conn, $_POST['confirmPass']);

			$name = cleanInput($name);
			$username = cleanInput($username);
			$birth = cleanInput($birth);
			$phone = cleanInput($phone);
			$email = cleanInput($email);
			$address = cleanInput($address);
			$password = cleanInput($password);

			//jika password tidak sama dengan repassword
			if ($password !== $confirmPass) {
				exit("Passwords do not match");
			}

			//memeriksa apakah email tersebut sudah ada
			$s = "SELECT COUNT(*) from `user` where email= '$email'";
			$result = mysqli_query($conn, $s);
			$num = mysqli_fetch_row($result)[0];
			
			//jika email sudah ada pada database
 			if ($num > 0) {
				//muncul alert dan kembali ke register
				echo "<script>alert('Email sudah terdaftar!')</script>";
				echo "<script>window.location.replace('register.php')</script>";
			} else {
				//jika email belum ada pada database
				$hashedpassword = password_hash($password, PASSWORD_DEFAULT); //untuk melakukan proses hash password
				//proses input data user
				$reg = "INSERT INTO `user`(`name`, `birth`, `email`, `username`, `password`, `phone`, `address`, `level`, `datejoined`) VALUES ('$name', '$birth', '$email', '$username','$hashedpassword', '$phone', '$address', '0' ,NOW())";

				if (mysqli_query($conn, $reg)) {
					//jika berhasil, redirect ke index dengan alert berhasil
					echo "<script>alert('Daftar berhasil, silahkan login')</script>";
					echo "<script>window.location.replace('index.php')</script>";
				} else {
					//jika berhasil, redirect ke index dengan alert berhasil
					echo "Sign up failed" . mysqli_error($conn);
				}
			}
		}
		?>

	<?php include("includes/footer.php"); ?>

</html>
