<?php
session_start();
include('connections/localhost.php');
$email = trim(mysqli_real_escape_string($conn, $_POST['email']));
$password = trim(mysqli_real_escape_string($conn, $_POST['password']));
$query =  mysqli_query($conn,"SELECT `password` FROM `user` WHERE `email`= '$email'");
$res = mysqli_fetch_assoc($query)["password"] or exit("User does not exist");

if (!password_verify($password, $res)){
    echo '<script>alert("Wrong email or password!...Try again."); document.location="index.php"</script>';
} else {
    $getname = mysqli_query($conn,"SELECT `name` FROM `user` WHERE `email`='$email'");
	$name = mysqli_fetch_assoc($getname)["name"];
    $getlevel = mysqli_query($conn,"SELECT `level` FROM `user` WHERE `email`='$email'");
	$level = mysqli_fetch_assoc($getlevel)["level"];

	$_SESSION['valid'] = true;
	$_SESSION['email'] = $email;
	$_SESSION['name'] = $name;
    if ($level == 1){
        $_SESSION['admin'] = $email;
        echo '<script>alert("Selamat Datang Admin '.$email.'");document.location="admin/index.php";</script>';
    } else {
        $_SESSION['user'] = $email;
        echo '<script>alert("Selamat Datang Pengunjung '.$email.'"); document.location="dashboard.php"</script>';
    }
}

?>