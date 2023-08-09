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
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Healthify</h3></div>
                                <div class="card-body">
                                    <form action="login.php" method="post" enctype="multipart/form-data">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#"></a>
                                            <input class="btn btn-dark" name="login" type="submit" value="Login">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">Belum punya akun? <a href="register.php">Daftar sekarang!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include("includes/footer.php"); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>