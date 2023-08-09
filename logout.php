<?php
session_start();
session_unset();
session_destroy();
//sesi dihapus dan redirect
echo '<p align="center">' . "You have logged out. Redirecting you..." . '</p>';
header( 'Refresh: 1; URL = index.php' );

?>