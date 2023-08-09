<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if (isset($_SESSION['email'])) {
	echo "<script>alert('Anda sudah login') </script>";
    if(isset($_SESSION['user'])){                                   //jika user adalah customer
        echo "<script>open('dashboard.php', '_self') </script>";    //redirect ke dashboard
    } else {                                                        //jika user adalah admin
        echo "<script>open('admin/index.php', '_self') </script>";  //redirect ke dashboard admin
    }
}
include('connections/localhost.php');

$email = trim(mysqli_real_escape_string($conn, $_POST['email']));               //mengambil data email
$password = trim(mysqli_real_escape_string($conn, $_POST['password']));         //mengambil data password
$query =  mysqli_query($conn,"SELECT `password` FROM `user` WHERE `email`= '$email'"); //mengambil password dari user dimana email sama dengan input
//jika ada, maka record password disimpan dalam variabel res, jika gagal akan kembali dengan alert email tidak ditemukan
$res = mysqli_fetch_assoc($query)["password"] or exit('<script>alert("'.$email.' tidak ditemukan. Silahkan daftar"); document.location="index.php"</script>');

if (!password_verify($password, $res)){ //verifikasi password yang telah terhash
    //jika input password dan variabel res tidak cocok, maka akan muncul alert dan redirect
    echo '<script>alert("Wrong email or password!...Try again."); document.location="index.php"</script>';
} else {
    $getname = mysqli_query($conn,"SELECT `name` FROM `user` WHERE `email`='$email'");
	$name = mysqli_fetch_assoc($getname)["name"];
    $getlevel = mysqli_query($conn,"SELECT `level` FROM `user` WHERE `email`='$email'");
	$level = mysqli_fetch_assoc($getlevel)["level"];

    //jika input password dan variabel res cocok, maka akan terdapat sesi
	$_SESSION['valid'] = true;
	$_SESSION['email'] = $email;
	$_SESSION['name'] = $name;

    //memeriksa apakah user adalah admin atau customer
    if ($level == 1){
        //jika admin, maka sesi sebagai admin dan redirect ke halaman admin
        $_SESSION['admin'] = $email;
        echo '<script>alert("Selamat Datang Admin '.$email.'");document.location="admin/index.php";</script>';
    } else {
        //jika customer maka sesi sebagai user dan redirect ke halaman dashboard
        $_SESSION['user'] = $email;
        echo '<script>alert("Selamat Datang Pengunjung '.$email.'"); document.location="dashboard.php"</script>';
    }
}

?>